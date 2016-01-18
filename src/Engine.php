<?php

namespace Imagize;

use Imagize\Model\Entities\Image;
use Storage\Loader;
use Storage\Storage;

class Engine {

    private $originalFilesLoader;
    private $resizedStorage;

    public function __construct(
        Storage $resizedStorage,
        Loader $originalFilesLoader
    ) {
        $this->resizedStorage = $resizedStorage;
        $this->originalFilesLoader = $originalFilesLoader;
    }

    private function makeKey($imageName, $width, $height) {
        return "$width/$height/$imageName";
    }


    public function serve($fileName, $width = 0, $height = 0)  {
        if ($width == 0 && $height == 0)
        {
            return $this->serveOriginal($fileName);
        }
        else{
            $key = $this->makeKey($fileName, $width, $height);
            if (!isset($this->resizedStorage[$key])) {
                $this->resizeOriginal($fileName, $width, $height);
            }
            return $this->resizedStorage[$key];
        }
    }

    private function serveOriginal($filename)
    {
        return $this->originalFilesLoader->getAsString($filename);
    }

    private function resizeOriginal($fileName, $width, $height)
    {
        $key = $this->makeKey($fileName, $width, $height);
        $originalImgString = $this->originalFilesLoader->getAsString($fileName);
        $image = new Image($originalImgString);
        $image->resize($width, $height);
        $this->resizedStorage[$key] = $image->getImageString();
    }

}