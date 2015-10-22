<?php

namespace Imagize;

use Imagize\Exceptions\ImageNotFoundException;
use Imagize\Exceptions\InvalidStringArgumentException;

class ImageFileLoader {

    private $path;

    public function __construct($path) {
        if (!is_string($path)) throw new InvalidStringArgumentException('path');
        $this->path = $path;
    }

    public function getImageFile($fileName) {

        $path = "$this->path/$fileName.png";
        if (!file_exists($path)) throw new ImageNotFoundException($path);

        return file_get_contents($path);

    }

}