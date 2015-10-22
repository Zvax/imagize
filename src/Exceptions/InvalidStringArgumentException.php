<?php

namespace Imagize\Exceptions;

class InvalidStringArgumentException extends \Exception {

    public function __construct($argName,$code = 0,$previous = null) {
        $msg = "the parameter $argName should be a string";
        parent::__construct($msg,$code,$previous);
    }

}