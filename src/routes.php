<?php
use Router\Router;
use App\Controllers\ProductController;
use \DI\Container;

return function (Container $container) {
    $productController = $container->get(ProductController::class);

    $router = Router::getInstance();

    $router->get("/products", [$productController, "list"]);
    $router->post("/products", [$productController, "create"]);
    $router->get("/products/:id", [$productController, "get"]);
    $router->patch("/products/:id", [$productController, "update"]);
    $router->delete("/products/:id", [$productController, "delete"]);
};

