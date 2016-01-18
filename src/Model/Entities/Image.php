<?php

namespace Imagize\Model\Entities;

class Image
{
    private $imageString;
    private $imageResource;

    private $type;
    private $width;
    private $height;

    private $fileName;
    private $extension;

    public function getImageString()
    {
        return $this->imageString;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function __construct($imageString)
    {
        $this->updateImageString($imageString);
    }

    private function updateImageString($imageString)
    {
        $this->imageString = $imageString;
        $info = getimagesizefromstring($this->imageString);
        $this->width = $info[0];
        $this->height = $info[1];
        $this->type = $info['mime'];
    }

    public function resize( $newWidth = 0, $newHeight = 0) {

        if ($newHeight === 0 && $newWidth === 0) {
            $newWidth = (int)$this->width;
            $newHeight = (int)$this->height;
        } else if ($newWidth === 0) {
            $ratio = $newHeight / $this->height;
            $newWidth = (int)$this->width * $ratio;

        } else if ($newHeight === 0) {
            $ratio = $newWidth / $this->width;
            $newHeight = (int)$this->height * $ratio;
        }
        $destination = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($destination, imagecreatefromstring($this->imageString), 0, 0, 0, 0, $newWidth, $newHeight, $this->width, $this->height);

        $this->updateImageString($this->resourceToString($destination));

    }

    private function resourceToString($resource)
    {
        ob_start();
        switch ($this->type)
        {
            case 'image/png':
                imagepng($resource);
                break;
            case 'image/gif':
                imagegif($resource);
                break;
            default:
                imagejpeg($resource);
        }
        return ob_get_clean();
    }

}