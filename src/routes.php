<?php

use App\Controllers\CategoryController;
use App\Controllers\TagController;
use Router\Router;
use App\Controllers\ProductController;
use \DI\Container;

return function (Container $container) {
    $productController = $container->get(ProductController::class);
    $tagController = $container->get(TagController::class);
    $categoryController = $container->get(CategoryController::class);

    $router = Router::getInstance();

    $router->get("/products", [$productController, "list"]);
    $router->post("/products", [$productController, "create"]);
    $router->get("/products/:id", [$productController, "get"]);
    $router->patch("/products/:id", [$productController, "update"]);
    $router->patch("/products/:id/like", [$productController, "like"]);
    $router->delete("/products/:id", [$productController, "delete"]);
    $router->post("/products/:id/tags", [$productController, "associateTags"]);

    $router->get("/tags", [$tagController, "list"]);
    $router->post("/tags", [$tagController, "create"]);
    $router->get("/tags/:id", [$tagController, "get"]);
    $router->patch("/tags/:id", [$tagController, "update"]);
    $router->delete("/tags/:id", [$tagController, "delete"]);

    $router->get("/categories", [$categoryController, "list"]);
    $router->post("/categories", [$categoryController, "create"]);
    $router->get("/categories/:id", [$categoryController, "get"]);
    $router->get("/categories/:id/products", [$categoryController, "listProducts"]);
    $router->patch("/categories/:id", [$categoryController, "update"]);
    $router->delete("/categories/:id", [$categoryController, "delete"]);
};
