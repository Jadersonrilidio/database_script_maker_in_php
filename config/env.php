<?php

use App\Utils\Environment;

const ENV_FILE_PATH = './';
const ENV_FILE_NAME = '.env';

$env = new Environment(ENV_FILE_PATH, ENV_FILE_NAME);

define('DEBUG_APP', $env->getenv('DEBUG_APP', false));
