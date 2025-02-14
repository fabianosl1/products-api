<?php
require __DIR__ . "/../vendor/autoload.php";

$di = require __DIR__ . "/../src/Infra/di.php";
$routes = require __DIR__ . "/../src/Infra/routes.php";

$container = $di();

$router = $routes($container);

$router->handler();