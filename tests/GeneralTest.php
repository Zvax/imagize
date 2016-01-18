<?php

class GeneralTest extends PHPUnit_Framework_TestCase
{
    public function testBlankEngine()
    {
        $storage = new \Storage\FileStorage(__DIR__.'/images/');
        $loader = new \Storage\FileLoader(__DIR__.'/images/');
        $engine = new \Imagize\Engine($storage, $loader);
        $this->assertInstanceOf('Imagize\Engine', $engine);

        $image = $engine->serve('wallpaper.jpg');
        $this->assertInternalType('string', $image);
    }

    public function testServingSavesResized()
    {
        $storage = new \Storage\FileStorage(__DIR__.'/images/');
        $loader = new \Storage\FileLoader(__DIR__.'/images/');
        $engine = new \Imagize\Engine($storage, $loader);

        $engine->serve('wallpaper.jpg', 600);

        $this->assertTrue(isset($storage['600/0/wallpaper.jpg']));
    }

    public function testImageCreationAndResize()
    {
        $loader = new \Storage\FileLoader(__DIR__.'/images/');
        $string = $loader->getAsString('wallpaper.jpg');
        $this->assertInternalType('string', $string);

        $image = new \Imagize\Model\Entities\Image($string);
        $this->assertEquals(1920, $image->getWidth());

        $image->resize(1000);
        $this->assertEquals(1000, $image->getWidth());

        $image->resize(500);
        $this->assertEquals(500, $image->getWidth());
    }
}