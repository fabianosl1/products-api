<?php
require __DIR__ . "/../vendor/autoload.php";

$di = require __DIR__ . "/../src/di.php";
$routes = require __DIR__ . "/../src/routes.php";

$container = $di();

$router = $routes($container);

$router->handler();