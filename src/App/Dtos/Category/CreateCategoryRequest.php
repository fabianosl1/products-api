<?php
namespace App\Dtos\Category;

use App\Entities\Category;
use App\Dtos\BaseRequest;
use App\Entities\EntityProvider;

/**
 * @extends BaseRequest<Category>
 * @implements EntityProvider<Category>
 */
class CreateCategoryRequest extends BaseRequest implements EntityProvider
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
