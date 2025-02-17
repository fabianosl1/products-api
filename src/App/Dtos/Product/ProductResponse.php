<?php
namespace App\Dtos\Product;

use App\Dtos\Category\CategoryResponse;
use App\Dtos\Tag\TagResponse;
use App\Entities\Product;
use App\Dtos\BaseResponse;

/**
 * @extends BaseResponse<Product>
 */
class ProductResponse extends BaseResponse
{
    public int $id;

    public string $name;

    public string $description;

    public float $price;

    public int $likes;

    public CategoryResponse $category;

    /**
     * @var TagResponse[]
     */
    public array $tags;

    public function __construct($product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->description = $product->getDescription();
        $this->price = $product->getPrice();
        $this->likes = $product->getLikes();

        $this->category = new CategoryResponse($product->getCategory());

        $tags = [];

        foreach ($product->getTags() as $tag) {
            $tags[]= new TagResponse($tag);
        }

        $this->tags = $tags;
    }

}
