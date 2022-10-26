<?php

namespace App\Core;

use App\Core\QueryBuilder;
use Database\DatabaseConnection as DBConnection;

class DatabaseScan
{
    /**
     * Example of the database datastructure to be created.
     *     (Will be overriden at method run execution until it's completion)
     * 
     * @var array
     */
    protected $dbStructure = array();

    /**
     * Database name.
     * 
     * @var string
     */
    protected $dbname;

    /**
     * Array containing database's table names.
     * 
     * @var array
     */
    protected $tables = array();

    /**
     * QueryBuilder instance.
     * 
     * @var App\Core\QueryBuilder
     */
    protected $builder;

    /**
     * Database instance.
     * 
     * @var Database\DatabaseConnection
     */
    protected $db;

    /**
     * Class constructor method.
     * 
     * @param  App\Core\QueryBuilder
     * @param  Database\DatabaseConnection  $conn
     * @param  string  $dbname
     * @return void
     */
    public function __construct(QueryBuilder $builder, DBConnection $db, string $dbname)
    {
        $this->builder = $builder;
        $this->db = $db;
        $this->dbname = $dbname;

        $this->scan();
    }

    /**
     * 
     */
    public function scan()
    {
        $this->getTables();

        foreach ($this->tables as $table)
            $this->handleTableColumns($table);
    }

    /**
     * Get all table names and store it on $tables attribute.
     * 
     * @return array
     */
    private function getTables()
    {
        $query = $this->builder->showTables()->getQuery();
        $results = $this->db->query($query);

        foreach ($results as $result)
            array_push($this->tables, $result[0]);

        return $this->tables;
    }

    /**
     * Get all columns from a given table.
     * 
     * @param  string  $table
     * @return array
     */
    private function handleTableColumns($table)
    {
        $query = $this->builder->showColumnsFromTable($table)->getQuery();
        $results = $this->db->query($query);

        foreach ($results as $result)
            $this->setDatabaseStructure($table, $result);
    }

    /**
     * 
     */
    private function setDatabaseStructure($table, $col)
    {
        $this->dbStructure[$this->dbname][$table][$col[0]] = $this->setColumn($col);
    }

    /**
     * 
     */
    private function setColumn($col)
    {
        $column = [];

        foreach ($col as $key => $value)
            if (!is_numeric($key))
                $column[strtolower($key)] = $value;

        return $column;
    }

    /**
     * 
     */
    public function getDatabaseStructure()
    {
        return $this->dbStructure;
    }
}
