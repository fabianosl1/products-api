<?php
ini_set('display_errors', 0);

use Router\Router;

require __DIR__ . "/../vendor/autoload.php";

$router = Router::getInstance();

$router->run(function () {
    $di = require __DIR__ . "/../src/di.php";
    $routes = require __DIR__ . "/../src/routes.php";

    $container = $di();
    $routes($container);
});
