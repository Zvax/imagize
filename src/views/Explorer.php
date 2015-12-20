<?php

namespace Views;

use ALL\Templating\Renderer;
use Http\Response;
use Model\HtmlPage;
use Storage\ImageFileLoader;

class Explorer
{
    private $response;
    private $renderer;
    private $imageLoader;
    private $htmlPage;

    public function __construct(
        Response $response,
        Renderer $renderer,
        ImageFileLoader $imageLoader,
        HtmlPage $htmlPage)
    {
        $this->response = $response;
        $this->renderer = $renderer;
        $this->imageLoader = $imageLoader;
        $this->htmlPage = $htmlPage;
    }

    public function show($path)
    {
        $images = $this->imageLoader->loadFolderImages($path);
        $nb = count($images);
        $i = isset($_SESSION['imgPos']) ? (int)$_SESSION['imgPos'] : 0;
        $this->htmlPage->contenu = $this->renderer->render('explorer', [
            'filename' => $images[$i]['filename'],
            'avant' => $i > 0,
            'apres' => $i < $nb,
            'i' => $i,
            'folder' => "$path",
        ]);
        $this->response->setContent($this->renderer->render('layout', $this->htmlPage));
    }
}