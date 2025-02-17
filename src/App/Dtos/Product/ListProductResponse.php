<?php
namespace App\Dtos\Product;
use App\Dtos\BaseResponse;
use App\Entities\Product;


/**
 * @extends BaseResponse<Product[]>
 */
class ListProductResponse extends BaseResponse {
    /**
     * @var ProductResponse[]
     */
    public array $products = [];

    public function __construct($products)
    {
        foreach ($products as $product) {
            $this->products[]= [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'categoryId' => $product->getCategoryId(),
            ];
        }
    }
}
