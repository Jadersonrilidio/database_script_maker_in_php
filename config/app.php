<?php

require __DIR__ . '/../autoload.php';

require __DIR__ . '/../config/env.php';
require __DIR__ . '/../config/database.php';

if (DEBUG_APP === 'true') {
    $dd = new App\Utils\Debug;
}
