<?php

namespace Imagize;

use ALL\Templating\MustacheRenderer;
use Http\Response;
use Storage\ImageFileCaching;
use Storage\ImageFileLoader;

class Imagize {

    private $imageLoader;
    private $image;
    private $imageCaching;
    private $renderer;
    private $response;

    public function __construct(
        ImageFileLoader $imageLoader,
        ImageFileCaching $imageCaching,
        Response $response,
        MustacheRenderer $mustacheRenderer
    ) {
        $this->imageLoader = $imageLoader;
        $this->imageCaching = $imageCaching;
        $this->response = $response;
        $this->renderer = $mustacheRenderer;
    }

    private function load($fileName) {
        $content = $this->imageLoader->getImageFile($fileName);
        $this->image = new Image($content);
        return $this->image;
    }

    private function makeKey($imageName, $width, $height) {
        return "$width/$height/$imageName";
    }

    public function serveOriginal($params) {
        $filename = $params['filename'];
        $this->response->setHeader('Content-Type:', 'image/png');
        $this->response->setContent($this->imageLoader->getImageFile($filename));
    }

    public function serveResized($params) {
        $imageName = $params['filename'];
        $width = $params['width'];
        $height = isset($params['height']) ? $params['height'] : 0;
        $key = $this->makeKey($imageName, $width, $height);
        if ($this->imageCaching->isCached($key)) {
            $this->output($key);
            return;
        }
        $image = $this->load($imageName);
        $this->resize($image, $imageName, $width, $height);
        $this->output($key);
    }

    private function act($action) {
        switch ($action) {
            case 'before':
                $_SESSION['imgPos'] -= 1;
                break;
            case 'after':
                $_SESSION['imgPos'] += 1;
                break;
        }
    }

    public function serveDirectory($params) {
        if (isset($params['action'])) {
            $this->act($params['action']);
        }
        $path = isset($params['path']) ? $params['path'] : '';
        $images = $this->imageLoader->loadFolderImages($path);
        $nb = count($images);
        $i = isset($_SESSION['imgPos']) ? (int)$_SESSION['imgPos'] : 0;
        $this->response->setContent($this->renderer->render('photos_collection', [
            'filename' => $images[$i]['filename'],
            'avant' => $i > 0,
            'apres' => $i < $nb,
            'i' => $i,
        ]));
    }

    private function output($slug) {
        $this->response->setHeader('Content-Type:', 'image/png');
        $this->response->setContent($this->imageCaching->get($slug));
    }

    private function resize(Image $image, $filename, $width = 0, $height = 0) {
        $image->resize($width, $height);
        $this->imageCaching->cache($this->makeKey($filename, $width, $height), $image);
    }

}