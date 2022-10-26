<?php

require __DIR__ . '/../config/env.php';
require __DIR__ . '/../config/database.php';

if (DEBUG_APP === 'true') {
    $d = new App\Utils\Debug;
}
