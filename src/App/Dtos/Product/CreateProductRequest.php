<?php

namespace App\Dtos\Product;

use App\Entities\Product;
use App\Dtos\BaseRequest;

/**
 * @extends BaseRequest<Product>
 */
class CreateProductRequest extends BaseRequest
{
    public string $name;

    public string $description;

    public string $price;

    public int $categoryId;

    /**
     * @var int[]
     */
    public array $tags;

    public function __construct($body)
    {
        $this->name = $body["name"];
        $this->description = $body["description"];
        $this->price = $body["price"];
        $this->categoryId = $body["categoryId"];
        $this->tags = $body["tags"];
    }

    public function toEntity(): Product
    {
        return new Product(
            $this->name,
            $this->description,
            $this->price
        );
    }
}