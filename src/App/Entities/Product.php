<?php

namespace App\Entities;

class Product
{
    public int|null $id = null;

    public string $name;

    public string $description;

    public string $price;
}