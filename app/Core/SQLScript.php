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
     * File name.
     * 
     * @var string
     */
    protected $fileName;

    /**
     * File extension.
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
     * File URL.
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
    public function __construct(array $dbStructure, string $fileExt = '.sql', string $filePath = __DIR__ . '/storage/files/')
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

        $this->builder = clone $this->builder;

        $dbname = array_key_first($this->dbs);

        $this->createDatabase($dbname);

        $this->useDatabase($dbname);

        foreach ($this->dbs[$dbname] as $key => $table)
            $this->createTable($key, $table);

        if ($this->closeFile())
            echo "SQL Writer: SQL script generated at - " . $this->fileUrl . " \n";
    }

    /**
     * Create a file according to fileUrl.
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
     * Method responsible for generate the database sql script and write it to file.
     * 
     * @param  string  $dbname
     * @return int|false
     */
    private function createDatabase($dbname)
    {
        $data = $this->builder->createDatabase($dbname)->charset()->collate()->close()->getQuery();

        $result = $this->writeOnFile($data);

        if ($result)
            echo "SQL Writer: Database '" . $dbname . "' sql script generated. \n";

        return $result;
    }

    /**
     * Method responsible for generate the use database sql script and write it to file.
     * 
     * @param  string  $dbname
     * @return int|false
     */
    private function useDatabase($dbname)
    {
        $data = $this->builder->useDatabase($dbname)->close()->getQuery();

        $result = $this->writeOnFile($data);

        return $result;
    }

    /**
     * Method responsible for generate the table sql script and write it to file.
     * 
     * @param  string  $key  The table name
     * @param  array  $table  Associative array containing table details and columns structure 
     * @return int|false
     */
    private function createTable($key, $table)
    {
        $data = $this->builder->createTable($key, $table)->close()->getQuery();

        $result = $this->writeOnFile($data);

        if ($result)
            echo "SQL Writer: Table '" . $key . "' sql script generated. \n";

        return $result;
    }

    /**
     * Write to file.
     * 
     * @param  string  $data
     * @return int|false
     */
    private function writeOnFile(string $data)
    {
        return fwrite($this->fileHandler, $data);
    }

    /**
     * Close opened file.
     * 
     * @return bool
     */
    private function closeFile()
    {
        return fclose($this->fileHandler);
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
