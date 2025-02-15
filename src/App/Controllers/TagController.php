<?php
namespace App\Controllers;

use App\Dtos\Response;
use App\Dtos\Tag\CreateTagRequest;
use App\Dtos\Tag\ListTagResponse;
use App\Dtos\Tag\TagResponse;
use App\Dtos\Tag\UpdateTagRequest;
use App\Services\TagService;

class TagController implements BaseController
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function create($request): Response
    {
        $body = new CreateTagRequest($request["body"]);
        $tag = $this->tagService->create($body);

        $response = new TagResponse($tag);
        return new Response($response, 201);
    }

    public function get($request): Response
    {
        $tag = $this->tagService->findById($request["variables"]["id"]);

        $response = new TagResponse($tag);
        return new Response($response, 200);
    }

    public function list($request): Response
    {
        $tags = $this->tagService->findAll();
        $response = new ListTagResponse($tags);

        return new Response($response);
    }

    public function update($request): Response
    {
        $tag = $this->tagService->update(
            $request["variables"]["id"],
            new UpdateTagRequest($request["body"])
        );

        $response = new TagResponse($tag);
        return new Response($response);
    }

    public function delete($request): Response
    {
        $tag = $this->tagService->delete($request["variables"]["id"]);
        $response = new TagResponse($tag);

        return new Response($response);
    }
}
