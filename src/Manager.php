<?php

namespace Imagize;

class Manager implements Imaging {

    private $engine;

    public function __construct(Engine $engine) {

        $this->engine = $engine;

    }

    public function save($path) {
        $this->engine->sauverVersPath($path);
    }

}