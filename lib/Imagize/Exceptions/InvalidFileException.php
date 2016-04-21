<?php

namespace Imagize\Exceptions;

use Exception;

class InvalidFileExceptions extends Exception
{
    public function __construct($path, $code = 0, Exception $previous = null)
    {
        $message = "the file $path is not a valid file";
        parent::__construct($message, $code, $previous);
    }
}