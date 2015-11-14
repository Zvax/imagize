<?php

namespace Imagize;

use Imagize\Exceptions\NotAnImageException;

class Imagize {

    private $imageLoader;
    private $image;

    public function __construct(ImageFileLoader $imageLoader) {
        $this->imageLoader = $imageLoader;
    }

    public function load($fileName) {
        $content = $this->imageLoader->getImageFile($fileName);
        $this->image = new Image($content);
        return $this->image;
    }

    public function save($path) {
        if ($this->image === null) throw new NotAnImageException($path);
        $this->image->sauverVersPath($path);
    }

    public function resize(Image $image, $width = 0, $height = 0) {
        $image->resize($width, $height);
    }

}