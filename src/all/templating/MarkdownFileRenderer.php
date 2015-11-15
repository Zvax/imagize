<?php
namespace ALL\Templating;

class MarkdownFileRenderer implements MarkdownRenderer {
    private $parsedown;

    public function __construct(\Parsedown $parsedown) {
        $this->parsedown = $parsedown;
    }

    public function parse($text) {
        return $this->parsedown->text($text);
    }
}