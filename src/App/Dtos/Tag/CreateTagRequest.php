<?php
namespace App\Dtos\Tag;

use App\Entities\Tag;
use App\Dtos\BaseRequest;

/**
 * @extends BaseRequest<Tag>
 */
class CreateTagRequest extends BaseRequest
{
    public string $name;

    public function __construct($body)
    {
        $this->name = $body["name"];
    }

    public function toEntity(): Tag
    {
        return new Tag(null, $this->name);
    }
}