<?php

namespace App\Ports\Output;
use App\Domain\Product;

interface ProductRepositoryPort
{
    public function save(Product $product): void;
    public function findByName(string $name): ?Product;

}