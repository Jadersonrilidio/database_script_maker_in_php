<?php

namespace Database;

use \PDO;

abstract class DatabaseConnection
{
    /**
     * Database connection.
     * 
     * @var mixed?
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
     * @param  string  $drive, $host, $port, $dbname, $username, $password
     * @param  array  $options
     * @return mixed?
     */
    abstract protected function connect();

    /**
     * Make a regular query transaction.
     * 
     * @param  string  $query
     * @return mixed?
     */
    abstract protected function query($query);

    /**
     * Make a statement transaction.
     * 
     * @param  string  $statement
     * @param  mixed  $vars...
     * @return mixed?
     */
    abstract protected function statement($query, ...$vars);

    /**
     * Get the connection attribute.
     * 
     * @return mixed?
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
