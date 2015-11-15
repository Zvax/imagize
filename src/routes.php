<?php

return [

    ['GET', '/images/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveOriginal']],
    ['GET', '/images/{width:[0-9]+}/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveResized']],
    ['GET', '/images/{width:[0-9]+}/{height:[0-9]+}/{filename:[a-zA-Z0-9_\/.]+}', ['Imagize\Imagize', 'serveResized']],

    ['GET', '/', ['Imagize\Imagize', 'serveDirectory']],
    ['GET', '/{action}', ['Imagize\Imagize', 'serveDirectory']],

];