<?php
require_once "Router.php";
require_once "RouterUtils.php";

$router = Router::getInstance();

$router->get("/products", function () {
    RouterUtils::makeResponse(["message" => "success"]);
});

