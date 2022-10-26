<?php

use Database\MySQLConnection;

switch ($env->getenv('DB_DRIVE', 'mysql')) {
    case 'mysql':
        $db = new MySQLConnection([
            'drive'    => $env->getenv('DB_DRIVE', 'mysql'),
            'host'     => $env->getenv('DB_HOST', 'localhost'),
            'port'     => $env->getenv('DB_PORT', '3306'),
            'dbname'   => $env->getenv('DB_NAME', 'database'),
            'username' => $env->getenv('DB_USERNAME', 'root'),
            'password' => $env->getenv('DB_PASSWORD', ''),
            'options'  => explode(';', $env->getenv('DB_OPTIONS', []))
        ]);
        break;

    case 'sqlite':
        break;

    case 'postgree':
        break;

    case 'redis':
        break;

    case 'aws':
        break;
}
