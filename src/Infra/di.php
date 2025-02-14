<?php
namespace Infra;
use App\Application\Services\ProductService;
use \DI\Container;

return function() {
    $container = new Container();

    $container->set('ProductService', ProductService::class);

    return $container;
};