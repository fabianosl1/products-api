<?php
namespace App\Controllers;

use App\Services\ProductService;
use App\Entities\Product;

class ProductController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function get($request): Product
    {
        $product = $this->productService->findById($request["variables"]["id"]);
        return $product;
    }
}