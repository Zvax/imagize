<?php

namespace Imagize;

use Imagize\Exceptions\InvalidFileExceptions;

class Factory
{
    public function buildImageFromFile($path)
    {
        if (!is_file($path))
        {
            throw new InvalidFileExceptions($path);
        }
    }
}