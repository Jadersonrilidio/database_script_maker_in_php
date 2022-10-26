<?php

namespace App\Utils;

class Debug
{
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
