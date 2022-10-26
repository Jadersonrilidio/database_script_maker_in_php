<?php

namespace App\Core;

class SQLWriter
{
    const TAB = "\n\t";
    const END = "\n\n";
    
    /**
     * Database structure representation.
     * 
     * @var array
     */
    protected $dbs;

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
     * File Handler instance.
     * 
     * @var \Handler
     */
    protected $fileHandler;

    /**
     * Class constructor method.
     * 
     * @param  array  $dbStructure
     * @param  string  $fileExt
     * @param  string  $filepath
     * @return void
     */
    public function __construct($dbStructure, $fileExt = '.txt', $filePath = BASE_PATH.'/storage/files/')
    {
        $this->dbs = $dbStructure;
        $this->fileExt = $fileExt;
        $this->filePath = $filePath;
        $this->setFileName();

        $this->createOpenFile();
    }

    public function run()
    {
        $data = $this->createDatabaseSqlScript();
        $this->writeOnFile($data);

        foreach ($this->dbs as $dbname => $tables)
            foreach ($tables as $table => $columns)
                foreach ($columns as $column => $attributes)
                    print_r($attributes);
    }

    /**
     * Create a file according to created parameters.
     * 
     * @return void
     */
    private function createOpenFile()
    {
        $fileUrl = $this->filePath . $this->fileName . $this->fileExt;

        $this->assertFileName($fileUrl);

        $this->fileHandler = fopen($fileUrl, 'a');
    }

    /**
     * Assert fileName passed by reference doesn't exists.
     * 
     * @param  string  $fileUrl
     * @return void
     */
    private function assertFileName(&$fileUrl)
    {
        if (!file_exists($fileUrl)) return;

        $counter = 1;
        $fileUrl = $fileUrl .'_'. $counter;

        while (file_exists($fileUrl))
            $fileUrl = str_replace('_'. $counter, '_'. ++$counter, $fileUrl);
    }

    /**
     * Write to file.
     */
    public function writeOnFile($data)
    {
        fwrite($this->fileHandler, $data);
    }

    /**
     * Mount SQL scripts.
     * 
     * @return string
     */
    private function createDatabaseSqlScript()
    {
        $script = "CREATE DATABASE IF NOT EXISTS "
            . $this->dbname
            . self::TAB . "DEFAULT CHARACTER SET = utf8 " 
            . self::TAB . "DEFAULT COLLATE = utf8_general_ci;" . self::END
            . "USE " . $this->dbname . ";" . self::END;

        return $script;
    }

    /**
     * Mount SQL scripts.
     * 
     * @return string
     */
    private function createTableSqlScript($table)
    {
        $script = "CREATE TABLE IF NOT EXISTS "
            . $table . " ( "
            . self::TAB . " COLUMN_01 " . ","
            . self::TAB . " ...       " . ","
            . self::TAB . " COLUMN_N  " . PHP_EOL
            . ");" . self::END;

        return $script;
    }

    /**
     * Mount SQL scripts.
     * 
     * @return string
     */
    private function createColumnSql($column)
    {
        $script = "";

        return $script;
    }

    /**
     * Create a fileName for the SQL script.
     * 
     * @return void
     */
    private function setFileName()
    {
        $this->fileName = array_key_first($this->dbs) . '_sql_script';
    }

    /**
     * 
     */
    private function writeCreateTableSQLCode($data)
    {
        $sql = "CREATE TABLE ";

        foreach ($data as $table => $columns) {
            $sql .= $table . " ( \n\t";

            foreach ($columns as $column) {
                $sql .= $column['field'] . " ";
                $sql .= strtoupper($column['type']) . " ";
                $sql .= ($column['key'] == 'PRI') ? "PRIMARY " : '';
                $sql .= ($column['null'] == "NO") ? "NOT NULL " : "NULL ";
                $sql .= ($column['default']) ? "DEFAULT '" . $column['default'] . "' " : '';
                $sql .= strtoupper($column['extra']) ?? '';
                $sql .= ", \n\t";
            }

            $sql = trim($sql);
            $sql = trim($sql, ',');
            $sql .= "\n);";
        }
    }
}