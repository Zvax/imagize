<?php

namespace Imagize;

class Manager implements Imaging {

    private $engine;
    private $imageLoader;

    public function __construct(Engine $engine,ImageFileLoader $imageLoader) {
        $this->engine = $engine;
        $this->imageLoader = $imageLoader;
    }

    public function save($path) {
        $this->engine->sauverVersPath($path);
    }

}