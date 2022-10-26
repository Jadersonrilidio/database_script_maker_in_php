<?php

namespace App\Utils;

class Debug
{
    /**
     * Class constructor method.
     * 
     * @return void
     */
    public function __construct()
    {
        echo "App Debug: running... \n";
    }

    /**
     * Class destructor method.
     * 
     * @return void
     */
    public function __destruct()
    {
        echo "App Debug: terminated... \n";
    }

    /**
     * Debug function.
     * 
     * @param  mixed|array  $vars
     * @return void
     */
    static public function debug(...$args)
    {
        $args = func_get_args();

        foreach ($args as $var) {
            print_r($var);
            echo "\n";
        }

        exit;
    }

    /**
     * Debug function with var_dump.
     * 
     * @param  mixed|array  $vars
     * @return void
     */
    static public function debugvd(...$args)
    {
        $args = func_get_args();

        foreach ($args as $var) {
            var_dump($var);
            echo "\n";
        }

        exit;
    }
}
