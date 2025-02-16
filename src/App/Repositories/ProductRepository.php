<?php
namespace App\Repositories;

use App\Entities\Product;

interface ProductRepository
{
    public function findById(int $id): ?Product;

    public function findByName(string $name): ?Product;

    /**
     * @return Product[]
     */
    public function findAll(string|null $orderBy): array;

    /**
     * @return Product[]
     */
    public function findByCategoryId(int $categoryId): array;

    public function save(Product $product): void;

    public function delete(Product $product): void;

}
