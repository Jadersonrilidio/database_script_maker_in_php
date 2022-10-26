<?php

namespace Database;

use \PDO;

class DatabaseConnection
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
     * @param  string  $drive, $host, $port, $dbname, $username, $password
     * @param  array  $options
     * @return void
     */
    public function __construct($drive, $host, $port, $dbname, $username, $password = '', $options = [])
    {
        $this->connection = $this->connect($drive, $host, $port, $dbname, $username, $password, $options);
    }

    /**
     * Set the connection with a database and return it as well.
     * 
     * @param  string  $drive, $host, $port, $dbname, $username, $password
     * @param  array  $options
     * @return ???
     */
    protected function connect($drive, $host, $port, $dbname, $username, $password = '', $options = [])
    {
        $dsn = $drive . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname;

        return new PDO($dsn, $username, $password, $options);
    }

    /**
     * Get the connection attribute.
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Make a regulat query.
     * 
     * @param  string  $query
     * @return mixed
     */
    public function query($query)
    {
        $result = $this->connection->query($query);

        return $result->fetchAll();
    }

    /**
     * Make a statement transaction.
     * 
     * @param  string  $statement
     * @param  mixed  $vars...
     * @return mixed
     */
    public function statement($query, ...$vars)
    {
        $args = func_get_args();
        $query = array_shift($args);

        //TODO
        // $statement = $this->connection->prepare($query);
        // $statement->bindParam();
        // $statement->bindParam();
        // $statement->execute();
        // $statement->fetch();
        // $statement->fetchAll();
    }
}
