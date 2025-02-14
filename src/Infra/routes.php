<?php
namespace App\Infra;

use App\Application\Services\ProductService;
use App\Infra\Router\Router;
use App\Infra\Router\RouterUtils;
use DI\Container;

return function (Container $container) {
    $router = Router::getInstance();
    $router->setContainer($container);

    $router->get("/products/:id", function () {
        $service = Router::getInstance()->getContainer()->get(ProductService::class);
        RouterUtils::makeResponse(["message" => ":id"]);
    });

    $router->get("/products", function () {
        $service = Router::getInstance()->getContainer()->get(ProductService::class);
        RouterUtils::makeResponse(["message" => "products"]);
    });
    return $router;
};

