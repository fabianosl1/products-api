<?php
require_once '../router/index.php';


$path = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router = Router::getInstance();
$router->handler($path, $method);
