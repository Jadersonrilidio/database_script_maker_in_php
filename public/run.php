<?php

require __DIR__ . '/../config/app.php';

use App\Core\DatabaseScan;
use App\Core\SQLScript;

$dbscan = new DatabaseScan(
    $conn    = $db,
    $dbname  = $env->getenv('DB_NAME')
);

$sqlWriter = new SQLScript(
    $dbs      = $dbscan->getDatabaseStructure(),
    $fileExt  = '.sql',
    $filePath = BASE_PATH . '/storage/files/'
);

$sqlWriter->write();
