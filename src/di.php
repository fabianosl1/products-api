<?php

use App\Controllers\CategoryController;
use App\Controllers\TagController;
use App\Controllers\ProductController;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\ProductRepository;
use App\Repositories\Impl\PostgresCategoryRepository;
use App\Repositories\Impl\PostgresTagRepository;
use App\Repositories\Impl\PostgresProductRepository;
use App\Services\CategoryService;
use App\Services\TagService;
use App\Services\ProductService;

return function () {
    $builder = new \DI\ContainerBuilder();

    $builder->addDefinitions([
        ProductRepository::class => \DI\autowire(PostgresProductRepository::class),
        ProductController::class => \DI\autowire(ProductController::class),
        ProductService::class => \DI\autowire(ProductService::class),
    ]);

    $builder->addDefinitions([
        CategoryRepository::class => \DI\autowire(PostgresCategoryRepository::class),
        CategoryController::class => \DI\autowire(CategoryController::class),
        CategoryService::class => \DI\autowire(CategoryService::class),
    ]);

    $builder->addDefinitions([
        TagRepository::class => \DI\autowire(PostgresTagRepository::class),
        TagController::class => \DI\autowire(TagController::class),
        TagService::class => \DI\autowire(TagService::class),
    ]);

    return $builder->build();
};