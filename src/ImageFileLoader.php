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

        if (!file_exists("$this->path/$fileName.png")) throw new ImageNotFoundException($fileName);

        return file_get_contents("$this->path/$fileName.png");

    }

}