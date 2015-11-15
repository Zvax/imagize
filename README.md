# imagize
gb image library wrapper and image server

default routes for serving an image:

```
    ['GET', '/', ['Imagize\Imagize', 'serveDirectory']],
    ['GET', '/images/{width:[0-9]+}/{height:[0-9]+}/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveResized']],
    ['GET', '/images/{width:[0-9]+}/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveResized']],
    ['GET', '/images/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveOriginal']],
```

basic instantiation

```
$imagize = new Imagize(
    new \Storage\ImageFileLoader('path/to/originals'),
    new \Storage\ImageFileCaching(new \Storage\FileStorage()),
    new \Http\HttpResponse(),
    new \ALL\Templating\MustacheRenderer(new \Mustache_Engine([
        ':options' => [
            'loader'=> new \Mustache_Loader_FilesystemLoader(__DIR__."/../templates",[
                'extension' => '.html',
            ]),
        ],
    ]))
);
```

