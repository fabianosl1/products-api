<?php
namespace App\Dtos\Category;
use App\Dtos\BaseResponse;
use App\Entities\Category;



/**
 * @extends BaseResponse<Category[]>
 */
class ListCategoryResponse extends BaseResponse {
    /**
     * @var CategoryResponse[]
     */
    public array $categories = [];

    public function __construct($categories)
    {
        foreach ($categories as $category) {
            $this->categories[]= new CategoryResponse($category);
        }
    }
}
