<?php

use App\Repositories\Impl\PostgresProductRepository;
use App\Repositories\ProductRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Controllers\ProductController;

return function () {
    $builder = new \DI\ContainerBuilder();

    $builder->addDefinitions([
        ProductRepository::class => \DI\autowire(PostgresProductRepository::class),
        ProductController::class => \DI\autowire(ProductController::class),
        ProductService::class => \DI\autowire(ProductService::class),
    ]);

    $builder->addDefinitions([
        \App\Services\CategoryService::class => \DI\autowire(CategoryService::class),
    ]);

    return $builder->build();
};