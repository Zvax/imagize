<?php

namespace Imagize\Exceptions;

class InvalidSizeException extends \Exception {

    public function __construct($size, $code = 0, \Exception $previous = null) {
        $msg = "this is not a valid file size: $size";
        parent::__construct($msg, $code, $previous);
    }

}