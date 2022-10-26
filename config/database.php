<?php

use Database\DatabaseConnection as DBConnection;

$db = new DBConnection(
    $drive    = $env->getenv('DB_DRIVE', 'mysql'),
    $host     = $env->getenv('DB_HOST', 'localhost'),
    $port     = $env->getenv('DB_PORT', '3306'),
    $dbname   = $env->getenv('DB_NAME', 'database'),
    $username = $env->getenv('DB_USERNAME', 'root'),
    $password = $env->getenv('DB_PASSWORD', ''),
    $options  = explode(';', $env->getenv('DB_OPTIONS', []))
);
