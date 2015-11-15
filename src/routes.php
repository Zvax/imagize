<?php

return [

    ['GET', '/images/{filename}', ['Imagize\Imagize', 'serveOriginal']],
    ['GET', '/images/{width:[0-9]+}/{filename}', ['Imagize\Imagize', 'serveResized']],
    ['GET', '/images/{width:[0-9]+}/{height:[0-9]+}/{filename}', ['Imagize\Imagize', 'serveResized']],

    ['GET', '/', ['Imagize\Imagize', 'serveDirectory']],
    ['GET', '/{action}', ['Imagize\Imagize', 'serveDirectory']],

];