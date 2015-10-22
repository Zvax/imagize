<?php

namespace Imagize\Exceptions;

class NotAnImageException extends \Exception {

    public function __construct($destinationPath,$code = 0,$previous = null) {
        $msg = "image to be saved at $destinationPath have not been created in manager";
        parent::__construct($msg,$code,$previous);
    }

}