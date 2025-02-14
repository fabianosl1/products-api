<?php
namespace App\Repositories;

use App\Entities\Product;

interface ProductRepository
{
    public function findById($id): Product;
    /**
     * 
     * @return Product[]
     */
    public function findAll(string|null $orderBy): array;
    public function save(Product $product): void;
    public function delete(Product $product): void;
}