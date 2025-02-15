<?php

use App\Repositories\CategoryRepository;
use App\Repositories\Impl\PostgresCategoryRepository;
use App\Repositories\Impl\PostgresProductRepository;
use App\Repositories\Impl\PostgresTagRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Controllers\ProductController;
use App\Services\TagService;

return function () {
    $builder = new \DI\ContainerBuilder();

    $builder->addDefinitions([
        ProductRepository::class => \DI\autowire(PostgresProductRepository::class),
        ProductController::class => \DI\autowire(ProductController::class),
        ProductService::class => \DI\autowire(ProductService::class),
    ]);

    $builder->addDefinitions([
        CategoryRepository::class => \DI\autowire(PostgresCategoryRepository::class),
        CategoryService::class => \DI\autowire(CategoryService::class),
    ]);

    $builder->addDefinitions([
        TagRepository::class => \DI\autowire(PostgresTagRepository::class),
        TagService::class => \DI\autowire(TagService::class),
    ]);

    return $builder->build();
};