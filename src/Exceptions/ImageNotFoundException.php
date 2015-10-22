<?php

namespace Imagize\Exceptions;

class ImageNotFoundException extends \Exception {

    public function __construct($imgName,$code = 0,$previous = null) {
        $msg = "this image doesn't exists: $imgName";
        parent::__construct($msg,$code,$previous);
    }

}