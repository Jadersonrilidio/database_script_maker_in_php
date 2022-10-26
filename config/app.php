<?php

require __DIR__ . '/../config/env.php';
require __DIR__ . '/../config/database.php';

if (DEBUG_APP === 'true') {
    require __DIR__ . '/../app/Utils/Debugger.php';
    echo "App Debug: running... \n";
}
