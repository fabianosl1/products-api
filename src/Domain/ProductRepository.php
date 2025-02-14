<?php

namespace App\Domain;

interface ProductRepository
{
    public function save(Product $product): void;
    public function findByName(string $name): ?Product;

}