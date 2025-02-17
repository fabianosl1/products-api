<?php
namespace App\Dtos\Category;

use App\Entities\Category;
use App\Dtos\BaseRequest;

/**
 * @extends BaseRequest<Category>
 */
class UpdateCategoryRequest extends BaseRequest
{
    public string $name;

    public function __construct($body)
    {
        $this->name = $body["name"];
    }

    public function update(Category $category): void
    {
        $category->setName($this->name ?? $category->getName());
    }
}