<?php

namespace App\Ports\Input;
use App\Domain\Product;

interface ProductServicePort
{
    public function save(Product $product): void;
}