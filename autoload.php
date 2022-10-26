<?php

spl_autoload_register(function ($class) {
    $relPaths = array(
        '/app/Utils/',
        '/app/Core/',
        '/database/'
    );

    $class = explode('\\', $class);
    $class = array_pop($class);

    foreach ($relPaths as $relpath)
        if (file_exists($file = __DIR__ . $relpath . $class . ".php"))
            require $file;
});
