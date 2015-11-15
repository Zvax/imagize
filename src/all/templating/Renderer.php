<?php

namespace ALL\Templating;

interface Renderer {
  public function render($template, $data = []);
}