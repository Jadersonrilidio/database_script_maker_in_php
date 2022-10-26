<?php

namespace Database;

abstract class DatabaseConnection
{
    /**
     * Database connection.
     * 
     * @var PDO
     */
    protected $connection;

    /**
     * Class constructor method.
     * 
     * @param  mixed  $args
     * @return void
     */
    public function __construct(...$args)
    {
        $this->connection = $this->connect(...$args);
    }

    /**
     * Set the connection with a database and return it as well.
     * 
     * @param  array  $array
     * @return mixed?
     */
    abstract protected function connect(array $array);

    /**
     * Make a regulat query.
     * 
     * @param  string  $query
     * @return mixed
     */
    abstract protected function query($query);

    /**
     * Make a statement transaction.
     * 
     * @param  string  $statement
     * @param  mixed  $vars...
     * @return mixed
     */
    abstract protected function statement($query, ...$vars);

    /**
     * Get the connection attribute.
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
