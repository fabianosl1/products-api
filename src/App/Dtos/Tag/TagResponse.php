<?php
namespace App\Dtos\Tag;

use App\Dtos\BaseResponse;
use App\Entities\Tag;

/**
 * @extends  BaseResponse<Tag>
 */
class TagResponse extends BaseResponse
{
    public int $id;

    public string $name;

    public function __construct($entity)
    {
        $this->id = $entity->getId();
        $this->name = $entity->getName();
    }
}