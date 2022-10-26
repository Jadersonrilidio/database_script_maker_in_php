<?php

namespace Database;

use Database\DatabaseConnection;
use \PDO;

class MySQLConnection extends DatabaseConnection
{
    /**
     * (Overriden method)
     * Set the connection with a database and return it as well.
     * 
     * @param  array  $args
     * @return ???
     */
    protected function connect(...$args)
    {
        extract(func_get_args());

        $dsn = $drive . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname;

        return new PDO($dsn, $username, $password, $options);
    }

    /**
     * (Overriden method)
     * Make a regular query transaction.
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
     * (Overriden method)
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
