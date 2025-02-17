<?php
namespace App\Dtos\Product;

use App\Dtos\BaseRequest;
use App\Entities\Product;

class UpdateProductRequest extends BaseRequest
{
    public ?string $name;

    public ?string $description;

    public ?float $price;

    public ?int $categoryId;

    public function __construct(array $body)
    {
        $this->name = $body["name"];
        $this->description = $body["description"];
        $this->price = $body["price"];
        $this->categoryId = $body["categoryId"];
    }

    public function update(Product $product): void {
        $product->setName($this->name ?? $product->getName());
        $product->setDescription($this->description ?? $product->getDescription());
        $product->setPrice($this->price ?? $product->getPrice());
        $product->setCategoryId($this->categoryId ?? $product->getCategoryId());
    }
}