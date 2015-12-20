<?php
$injector = new \Auryn\Injector();

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpRequest');
$injector->define('Http\Request', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':files' => $_FILES,
    ':cookies' => $_COOKIE,
    ':server' => $_SERVER,
]);

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');


$injector->define('Mustache_Engine',[
    ':options' => [
        'loader'=> new Mustache_Loader_FilesystemLoader(__DIR__."/../templates",[
            'extension' => '.html',
        ]),
    ]
]);

$injector->alias('ALL\Templating\Renderer','ALL\Templating\MustacheRenderer');

$injector->define('ALL\Templating\PhpRenderer',[
    ':paths' => [
        __DIR__.'/../templates/',
    ],
]);

$injector->alias('ALL\Pages\PageReader','ALL\Pages\FilePageReader');
$injector->define('ALL\Pages\FilePageReader',[
    ':pageFolder' => __DIR__.'/../pages/',
]);

$injector->alias('ALL\Templating\MarkdownRenderer','ALL\Templating\MarkdownFileRenderer');


$injector->define('Storage\ImageFileCaching',[
    ':storage' => new \Storage\FileStorage(),
]);


$config = parse_ini_file(__DIR__."/../config/imagize.ini");
$path = isset($_SESSION['path']) ? $_SESSION['path'] : "";
$injector->define('Storage\ImageFileLoader',[
    ':path' => "$config[root]$path",
]);

return $injector;