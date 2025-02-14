<?php
namespace App\Infra;

use App\Infra\Router\Router;
use App\Infra\Controller\ProductController;
use DI\Container;

return function (Container $container) {
    $productController = $container->get(ProductController::class);

    $router = Router::getInstance();

    $router->post("/:id/:transaction", [$productController, 'get']);

    return $router;
};

