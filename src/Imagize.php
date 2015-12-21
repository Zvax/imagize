<?php

namespace Imagize;

use ALL\Templating\MustacheRenderer;
use Http\Response;
use Storage\ImageFileCaching;
use Storage\ImageFileLoader;
use Views\Explorer;

class Imagize {

    private $imageLoader;
    private $image;
    private $imageCaching;
    private $renderer;
    private $response;
    private $view;

    public function __construct(
        ImageFileLoader $imageLoader,
        ImageFileCaching $imageCaching,
        Response $response,
        MustacheRenderer $mustacheRenderer,
        Explorer $view
    ) {
        $this->imageLoader = $imageLoader;
        $this->imageCaching = $imageCaching;
        $this->response = $response;
        $this->renderer = $mustacheRenderer;
        $this->view = $view;
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
        $this->response->setHeader('Content-Type', 'image/png');
        $this->response->setContent($this->imageLoader->getImageFile($filename));
    }

    public function changePath($params) {
        $_SESSION['path'] = $params['path'];
        $this->serveDirectory([
            'path' => $_SESSION['path'],
        ]);
    }

    public function serveResized($params)  {
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
        $path = isset($params['path']) ? $params['path'] : (isset($_SESSION['path']) ? $_SESSION['path'] : "");
        $this->view->show($path);
    }

    private function output($slug) {
        $this->response->setHeader('Content-Type', 'image/png');
        $this->response->setContent($this->imageCaching->get($slug));
    }

    private function resize(Image $image, $filename, $width = 0, $height = 0) {
        $start = microtime(true);
        $image->resize($width, $height);
        $end = microtime(true);
        $time = $end-$start;
        file_put_contents("resized in $time seconds\n",__DIR__."/../data/logs/logs.txt",FILE_APPEND);
        $this->imageCaching->cache($this->makeKey($filename, $width, $height), $image);
    }

}