<?php

namespace Imagize;

class Image {

    private $resource;
    private $width;
    private $height;

    public function __construct($content) {

        $imageInfo = getimagesizefromstring($content);
        $this->width = $imageInfo[0];
        $this->height = $imageInfo[1];

        $this->resource = imagecreatefromstring($content);

    }

}