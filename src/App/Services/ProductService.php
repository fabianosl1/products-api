<?php
namespace App\Services;
use App\Entities\Product;


class ProductService
{
    public function findById(int $id): Product
    {
        $product = new Product();

        $product->id = $id;

        return $product;
    }
}