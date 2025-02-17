<?php

namespace App\Dtos\Product;

use App\Entities\EntityProvider;
use App\Entities\Product;
use App\Dtos\BaseRequest;

/**
 * @extends BaseRequest<Product>
 * @implements EntityProvider<Product>
 */
class CreateProductRequest extends BaseRequest implements EntityProvider
{
    public string $name;

    public string $description;

    public float $price;

    public int $categoryId;

    /**
     * @var int[]
     */
    public array $tagsIds;

    public function __construct($body)
    {
        $this->name = $body["name"];
        $this->description = $body["description"];
        $this->price = $body["price"];
        $this->categoryId = $body["categoryId"];
        $this->tagsIds = $body["tags"];
    }

    public function toEntity(): Product
    {
        return new Product(
            name: $this->name,
            description: $this->description,
            price: $this->price,
            categoryId: $this->categoryId
        );
    }
}
