<?php

namespace App\Domain;

class Product
{
    public string|null $id = null;

    public string $name;

    public string $description;

    public string $price;
}