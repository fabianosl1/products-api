<?php
namespace App\Dtos\Product;

use App\Dtos\BaseRequest;
use App\Entities\Product;

class UpdateProductRequest extends BaseRequest
{
    public string $name;

    public string $description;

    public string $price;

    public int $categoryId;

    public function __construct(array $body)
    {
        $this->name = $body["name"];
        $this->description = $body["description"];
        $this->price = $body["price"];
        $this->categoryId = $body["categoryId"];
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