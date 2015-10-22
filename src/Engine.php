<?php

namespace Imagize;

class Engine {

    private $Ressource;
    private $Type;
    private $Width;
    private $Height;

    public static function fromPath($vPath) {
        $oImage = new self();
        $oImage->createRessource($vPath);
        return $oImage;
    }

    public function getWidth() {
        return $this->Width;
    }

    public function getHeight() {
        return $this->Height;
    }

    public function sauverVersPath($vPath) {
        switch ($this->Type) {
            case IMAGETYPE_GIF:
                imagegif($this->Ressource,$vPath);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($this->Ressource,$vPath);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->Ressource,$vPath);
                break;
        }
    }

    public function redimensionner($vNewWidth,$vNewHeight) {
        if ($vNewWidth === 0) {
            $vRatio = $vNewHeight / $this->Height;
            $vNewWidth = (int)$this->Width * $vRatio;

        } else if ($vNewHeight === 0) {
            $vRatio = $vNewWidth / $this->Width;
            $vNewHeight = $this->Height * $vRatio;
        }
        $oDestination = imagecreatetruecolor($vNewWidth,$vNewHeight);
        imagecopyresampled($oDestination,$this->Ressource,0,0,0,0,$vNewWidth,$vNewHeight,$this->Width,$this->Height);
        $this->Ressource = $oDestination;
        $this->Height = $vNewHeight;
        $this->Width = $vNewWidth;
    }

    private function createRessource($vPath) {
        $aInfosInitiales = \getimagesize($vPath);
        $this->Type = $aInfosInitiales[2];
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

        $this->Width = $aInfosInitiales[0];
        $this->Height = $aInfosInitiales[1];

    }

}