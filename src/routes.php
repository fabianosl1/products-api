<?php
use Router\Router;
use App\Controllers\ProductController;
use \DI\Container;

return function (Container $container) {
    $productController = $container->get(ProductController::class);

    $router = Router::getInstance();

    $router->get("/products/:id", [$productController, 'get']);

    return $router;
};

