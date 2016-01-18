<?php

Namespace Imagize;

use Auryn\Injector;
use Stepping\Engine;
use Stepping\Step;

require __DIR__ . "/../vendor/autoload.php";

session_start();

$injector = new Injector();
/** @var \Stepping\InjectionParams $injectionParams */
$injectionParams = getInjectionParams();
$injectionParams->addToInjector($injector);

/** @var \Http\Response $response */
$response = $injector->make('Http\Response');

$step = new Step('Imagize\routeRequest');
$app = new Engine($injector,$step);
$app->execute();

foreach ($response->getHeaders() as $header) {
    header($header, false);
}
echo $response->getContent();