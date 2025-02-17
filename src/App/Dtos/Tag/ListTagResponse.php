<?php
namespace App\Dtos\Tag;
use App\Dtos\BaseResponse;
use App\Entities\Tag;



/**
 * @extends BaseResponse<Tag[]>
 */
class ListTagResponse extends BaseResponse {
    /**
     * @var TagResponse[]
     */
    public array $tags = [];

    public function __construct($tags)
    {
        foreach ($tags as $tag) {
            $this->tags[]= new TagResponse($tag);
        }
    }
}
