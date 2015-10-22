<?php

namespace Imagize;

interface Imaging {
    public function save($path);
    public function load($fileName);
}