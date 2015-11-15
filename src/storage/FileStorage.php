<?php

namespace Storage;

class FileStorage implements \ArrayAccess {

    private $root;

    public function __construct($root = __DIR__.'/../../data/images/') {
        if (!is_dir($root)) mkdir($root);
        $this->root = $root;
    }

    public function offsetExists($offset) {
        return file_exists("$this->root$offset");
    }

    public function offsetGet($offset) {
        return file_get_contents("$this->root$offset");
    }

    public function offsetSet($offset, $value) {
        if (!is_dir($this->pathify($offset))) mkdir($this->pathify($offset),0755,true);
        file_put_contents("$this->root$offset",$value);
    }

    public function offsetUnset($offset) {
        unlink("$this->root$offset");
    }

    public function getPath($offset) {
        return "$this->root$offset";
    }

    private function pathify($offset) {
        $bits = explode('/',"$this->root$offset");
        array_pop($bits);
        return implode('/',$bits);
    }

}