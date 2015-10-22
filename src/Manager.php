<?php

namespace Imagize;

class Manager implements Imaging {

    private $engine;
    private $imageLoader;

    private $image;

    public function __construct(Engine $engine,ImageFileLoader $imageLoader) {
        $this->engine = $engine;
        $this->imageLoader = $imageLoader;
    }

    public function save($path) {
        $this->engine->sauverVersPath($path);
    }

    public function load($fileName) {
        $content = $this->imageLoader->getImageFile($fileName);
        $image = new Image($content);
        return $image;
    }

}