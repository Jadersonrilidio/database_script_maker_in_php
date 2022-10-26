<?php

namespace App\Core;

class QueryBuilder
{
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