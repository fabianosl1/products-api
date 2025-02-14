<?php
use App\Services\ProductService;
use App\Controllers\ProductController;
use \DI\Container;

return function () {
    $container = new Container();

    $container->set('ProductService', ProductService::class);
    $container->set('ProductController', ProductController::class);
    return $container;
};