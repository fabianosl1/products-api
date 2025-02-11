<?php
require_once "Router.php";
require_once "RouterUtils.php";


$router = new Router();

$router->post("/", function() {

});

$path = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->handler($path, $method);
