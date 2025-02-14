<?php
namespace Infra;
use App\Application\Services\ProductService;
use App\Infra\Controller\ProductController;
use \DI\Container;

return function () {
    $container = new Container();

    $container->set('ProductService', ProductService::class);
    $container->set('ProductController', ProductController::class);
    return $container;
};