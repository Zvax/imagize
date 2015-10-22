<?php

namespace Imagize;

use Imagize\Exceptions\ImageNotFoundException;
use Imagize\Exceptions\InvalidStringArgumentException;

class ImageFileLoader {

    private $path;
    private $extension;

    public function __construct($path,$extension = '.png') {
        if (!is_string($path)) throw new InvalidStringArgumentException('path');
        $this->path = $path;
        $this->extension = $extension;
    }

    public function getImageFile($fileName) {

        $path = "$this->path/$fileName$this->extension";
        if (!file_exists($path)) throw new ImageNotFoundException($path);

        return file_get_contents($path);

    }

}