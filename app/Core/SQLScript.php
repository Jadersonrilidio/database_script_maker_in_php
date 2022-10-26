<?php

namespace App\Core;

use App\Core\QueryBuilder;

class SQLScript
{
    /**
     * Database structure representation.
     * 
     * @var array
     */
    protected $dbs;

    /**
     * QueryBuilder instance.
     * 
     * @var App\Core\QueryBuilder
     */
    protected $builder;

    /**
     * The generated file name.
     * 
     * @var string
     */
    protected $fileName;

    /**
     * The generated file extension.
     * 
     * @var string
     */
    protected $fileExt;

    /**
     * File path.
     * 
     * @var string
     */
    protected $filePath;

    /**
     * Validated file full URL.
     * 
     * @var string
     */
    protected $fileUrl;

    /**
     * File Handler instance.
     * 
     * @var \Handler
     */
    protected $fileHandler;

    /**
     * Open file if exists.
     * 
     * @var bool
     */
    protected $override = false;

    /**
     * Class constructor method.
     * 
     * @param  array  $dbStructure
     * @param  string  $fileExt
     * @param  string  $filepath
     * @return void
     */
    public function __construct(array $dbStructure, string $fileExt = '.sql', string $filePath = BASE_PATH . '/storage/files/')
    {
        $this->dbs = $dbStructure;
        $this->builder = new QueryBuilder;
        $this->fileExt = $fileExt;
        $this->filePath = $filePath;
        $this->setFileName();
        $this->setFileUrl();
    }

    /**
     * Creates or open a file and write the database script on it.
     * 
     * @return void
     */
    public function write()
    {
        $this->createOpenFile();

        $dbname = array_key_first($this->dbs);

        $data = $this->builder->createDatabase($dbname)->charset()->collate()->close()->getQuery();
        $this->writeOnFile($data);

        $data = $this->builder->useDatabase($dbname)->close()->getQuery();
        $this->writeOnFile($data);

        foreach ($this->dbs[$dbname] as $key => $table) {
            $data = $this->builder->createTable($key, $table)->close()->getQuery();
            $this->writeOnFile($data);
        }

        $this->closeFile();

        echo "SQL Writer: SQL script created at - " . $this->fileUrl . " \n";
    }

    /**
     * Create a file according to created parameters.
     * 
     * @return void
     */
    private function createOpenFile()
    {
        $fileUrl = $this->assertFileName($this->override);

        $this->fileHandler = fopen($fileUrl, 'w');

        echo ($this->fileHandler)
            ? "SQL Writer: File created \n"
            : "SQL Writer: Error on create file \n";
    }

    /**
     * Assert fileName passed by reference doesn't exists.
     * 
     * @param  bool  $override
     * @return string
     */
    private function assertFileName(bool $override = false)
    {
        if ($override === true)
            return $this->fileUrl;

        $counter = 0;

        while (file_exists($this->fileUrl))
            $this->fileUrl = $this->filePath . $this->fileName . '(' . ++$counter . ')' . $this->fileExt;

        $this->fileName = $this->fileName . '(' . $counter . ')';

        return $this->fileUrl;
    }

    /**
     * Write to file.
     * 
     * @return void
     */
    public function writeOnFile($data)
    {
        fwrite($this->fileHandler, $data);
    }

    /**
     * Close opened file.
     * 
     * @return void
     */
    private function closeFile()
    {
        fclose($this->fileHandler);
    }

    /**
     * Create a fileName for the SQL script.
     * 
     * @return void
     */
    private function setFileName()
    {
        $this->fileName = array_key_first($this->dbs) . '_script';
    }

    /**
     * Create file URL.
     * 
     * @return void
     */
    private function setFileUrl()
    {
        $this->fileUrl = $this->filePath . $this->fileName . $this->fileExt;
    }
}
