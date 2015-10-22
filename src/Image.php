<?php

namespace Imagize;

class Image {

    private $resource;

    public function __construct($content) {

        $imageInfo = getimagesizefromstring($content);

        var_dump($imageInfo);

        switch ($this->Type) {
            case IMAGETYPE_GIF:
                $this->Ressource = imagecreatefromgif($vPath);
                break;
            case IMAGETYPE_JPEG:
                $this->Ressource = imagecreatefromjpeg($vPath);
                break;
            case IMAGETYPE_PNG:
                $this->Ressource = imagecreatefrompng($vPath);
                break;
        }

    }

}