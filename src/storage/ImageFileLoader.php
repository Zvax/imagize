<?php

namespace Storage;

use Imagize\Exceptions\ImageNotFoundException;
use Imagize\Exceptions\InvalidStringArgumentException;

class ImageFileLoader {

    private $path;
    private $extension;

    public function __construct($path,$extension = '') {
        if (!is_string($path)) throw new InvalidStringArgumentException('path');
        $this->path = $path;
        $this->extension = $extension;
    }

    public function loadFolderImages() {
        $files = new \DirectoryIterator("$this->path");
        $images = [];
        foreach ($files as $file) {
            if (
                $file->getBasename() === '.'
                || $file->getBasename() === '..'
            )
            {
                continue;
            }
            $images[] = [
                'filename' => $file->getFilename(),
            ];
        }
        return $images;
    }

    public function getImageFile($fileName) {

        $path = "$this->path/$fileName$this->extension";
        if (!file_exists($path)) throw new ImageNotFoundException($path);

        return file_get_contents($path);

    }

    public function getPath()
    {
        return $this->path;
    }

}