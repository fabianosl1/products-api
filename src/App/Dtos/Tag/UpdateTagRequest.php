<?php
namespace App\Dtos\Tag;

use App\Dtos\BaseRequest;
use App\Entities\Tag;

/**
 * @extends BaseRequest<Tag>
 */
class UpdateTagRequest extends BaseRequest
{
    public string $name;

    public function __construct($body)
    {
        $this->name = $body["name"];
    }

    public function update(Tag $tag): void
    {
        $tag->setName($this->name ?? $tag->getName());
    }
}