<?php

require __DIR__ . '/../autoload.php';
require __DIR__ . '/../config/app.php';

use App\Core\DatabaseScan;
use App\Core\SQLWriter;
use App\Core\QueryBuilder;

$dbscan = new DatabaseScan(
    $builder = new QueryBuilder,
    $conn    = $db,
    $dbname  = $env->getenv('DB_NAME')
);

$dbStructure = $dbscan->getDatabaseStructure();

$sqlWriter = new SQLWriter($dbStructure, '.txt');
