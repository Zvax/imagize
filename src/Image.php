<?php

namespace Imagize;

class Image {

    private $resource;
    private $width;
    private $height;
    private $type;
    private $typeString;

    public function __construct($content) {

        $imageInfo = getimagesizefromstring($content);
        $this->width = $imageInfo[0];
        $this->height = $imageInfo[1];
        $this->type = $imageInfo[2];
        $this->typeString = $imageInfo['mime'];

        $this->resource = imagecreatefromstring($content);

    }

    public function getMime() {
        return $this->typeString;
    }

    public function getRessource() {
        return $this->resource;
    }

    public function outputImage() {
        switch ($this->type) {
            case IMAGETYPE_GIF:
                return imagegif($this->resource);
            case IMAGETYPE_JPEG:
                return imagejpeg($this->resource);
            case IMAGETYPE_PNG:
                return imagepng($this->resource);
        }
        return false;
    }

    public function redimensionner($newWidth,$newHeight) {
        if ($newWidth === 0) {
            $ratio = $newHeight / $this->height;
            $newWidth = (int)$this->width * $ratio;

        } else if ($newHeight === 0) {
            $ratio = $newWidth / $this->width;
            $newHeight = (int)$this->height * $ratio;
        }
        $destination = imagecreatetruecolor($newWidth,$newHeight);
        imagecopyresampled($destination,$this->resource,0,0,0,0,$newWidth,$newHeight,$this->width,$this->height);
        $this->resource = $destination;
        $this->height = $newHeight;
        $this->width = $newWidth;
    }

}