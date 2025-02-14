<?php
namespace App\Dtos\Category;

use App\Entities\Category;
use App\Dtos\BaseResponse;

/**
 * @extends BaseResponse<Category>
 */
class CategoryResponse extends BaseResponse
{
    public int $id;
    public string $name;

    public function __construct($entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
    }
}