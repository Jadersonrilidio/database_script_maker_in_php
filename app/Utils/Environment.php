<?php

namespace App\Utils;

use \ErrorException;

/**
 * Responsible for handling the variables stored in .env file.
 * 
 */
class Environment
{
    // /**
    //  * Regex expressions used for validation.
    //  * 
    //  * @var string
    //  */
    // const REGEX_ENV_LINE = '/^[a-zA-Z0-9_]+=()+$/';

    /**
     * The env file URL.
     * 
     * @var string
     */
    protected $fileUrl;

    /**
     * Class constructor method.
     * 
     * @param  string  $path
     * @param  string  $name
     * @return void
     */
    public function __construct(string $path, string $name)
    {
        $this->setFileUrl($path, $name);
    }

    //TODO - not yet in use, test further to use putenv() and getenv() functions
    // /**
    //  * Set the environment variables.
    //  * 
    //  * @return void
    //  */
    // public function setenv()
    // {
    //     if (!$this->fileExists())
    //         return;

    //     $handle = $this->handleFile();

    //     while ($line = fgets($handle))
    //         if (preg_match('/^([A-Z0-9_]+)=([a-zA-Z0-9_]+)$/', $line))
    //             putenv($line);

    //     fclose($handle);
    // }


    /**
     * Return the variable value stored at .env file, if exists. If not, return the given default argument or an empty string.
     * 
     * @param  string  $varName
     * @param  string  $default
     * @return string
     */
    public function getenv(string $varName, $default = '')
    {
        if (!file_exists($this->fileUrl))
            return $default;

        $handle = $this->handleFile();
        $varName = strtoupper($varName);
        $value = null;

        while ($line = fgets($handle))
            if (strstr($line, $varName))
                $value = explode('=', $line)[1];

        fclose($handle);

        return ($value)
            ? trim($value)
            : $default;
    }

    /**
     * Set the env file URL.
     * 
     * @param  string  $path
     * @param  string  $name
     * @return void
     */
    private function setFileUrl(string $path, string $name)
    {
        $this->fileUrl = $path . $name;
    }

    /**
     * Return the file resource or throw a new ErrorException.
     * 
     * @return Resource|ErrorException
     */
    private function handleFile()
    {
        try {
            $handle = fopen($this->fileUrl, 'r');
        } catch(ErrorException $e) {
            throw new ErrorException( 'Error Exception => ' . $e);
        }

        return $handle;
    }
}
