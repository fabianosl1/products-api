<?php
namespace App\Dtos\Category;

use App\Entities\Category;
use App\Dtos\BaseRequest;

/**
 * @extends BaseRequest<Category>
 */
class CreateCategoryRequest extends BaseRequest
{
    public string $name;

    public function __construct($body)
    {
        $this->name = $body["name"];
    }

    public function toEntity(): Category
    {
        return new Category(null, $this->name);
    }
}