<?php

namespace App\Core;

class QueryBuilder
{
    const TAB = "\n\t";
    const END = "\n\n";

    /**
     * Query string.
     * 
     * @var string
     */
    protected $query = '';

    /**
     * Query string.
     * 
     * @var string
     */
    protected $defaultQuery = '';

    /**
     * Build a query to show db tables.
     * 
     * @return App\Core\QueryBuilder
     */
    public function showTables()
    {
        $this->query = $this->query . "SHOW TABLES ";

        return $this;
    }

    /**
     * 
     */
    public function showColumnsFromTable($table)
    {
        $this->query = $this->query . "SHOW COLUMNS FROM " . $table;

        return $this;
    }

    //TODO
    // Helper functions for script building in SQLWriter class
    // =====================================================================

    /**
     * Build a query to create database if not exists.
     * 
     * @param  string  $dbname
     * @return App\Core\QueryBuilder
     */
    public function createDatabase(string $dbname)
    {
        $this->query .= "CREATE DATABASE IF NOT EXISTS " . strtolower($dbname);

        return $this;
    }

    /**
     * Add charset information.
     * 
     * @param  string  $charset
     * @return App\Core\QueryBuilder
     */
    public function charset(string $charset = 'utf8')
    {
        $this->query .= self::TAB . "DEFAULT CHARACTER SET = " . strtolower($charset);

        return $this;
    }

    /**
     * Add collation type information.
     * 
     * @param  string  $collation
     * @return App\Core\QueryBuilder
     */
    public function collate(string $collation = 'utf8_general_ci')
    {
        $this->query .= self::TAB . "DEFAULT COLLATE = " . strtolower($collation);

        return $this;
    }

    /**
     * Create database SQL script.
     * 
     * @param  string  $dbname
     * @return App\Core\QueryBuilder
     */
    public function useDatabase(string $dbname)
    {
        $this->query .= "USE " . $dbname;

        return $this;
    }

    /**
     * DESCRIPTION
     * 
     * @param  string  $name
     * @param  array  $table
     * @return App\Core\QueryBuilder;
     */
    public function createTable(string $name, array $table)
    {
        $this->query .= " CREATE TABLE IF NOT EXISTS "
            . strtolower($name)
            . " ( "
            . $this->insertColumns($table) . PHP_EOL
            . " )";

        return $this;
    }

    /**
     * DESCRIPTION
     * 
     * @param  array  $column
     * @return string;
     */
    private function insertColumns($columns)
    {
        $script = '';

        foreach ($columns as $column)
            $script .= $this->createColumn($column) . ',';

        return trim($script, ',');
    }

    /**
     * DESCRIPTION
     * 
     * @param  array  $column
     * @return string;
     */
    private function createColumn($column)
    {
        extract($column);

        $field = strtolower($field) . ' ';
        $type = strtoupper($type) . ' ';
        $key = ($key == 'PRI') ? 'PRIMARY ' : '';
        $null = ($null != 'NULL') ? 'NOT NULL ' : '';
        $extra = ($extra) ? strtoupper($extra)  . ' ' : '';

        if ($default) {
            $default = (is_numeric($default) or is_bool($default))
                ? $default = 'DEFAULT ' . $default  . ' '
                : $default = "DEFAULT '" . $default  . "' ";
        }

        return self::TAB . $field . $type . $key . $null . $default . $extra;
    }

    // =====================================================================

    /**
     * Close the query string properly.
     * 
     * @return App\Core\QueryBuilder
     */
    public function close()
    {
        $this->query .= ";" . self::END;

        return $this;
    }

    /**
     * Return the built query and reset it to default.
     * 
     * @return string
     */
    public function getQuery()
    {
        $query = $this->query;

        $this->query = $this->defaultQuery;

        return $query;
    }
}
