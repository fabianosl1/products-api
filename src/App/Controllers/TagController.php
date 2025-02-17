<?php
namespace App\Controllers;

use Router\Response;
use Router\Request;
use App\Dtos\Tag\CreateTagRequest;
use App\Dtos\Tag\ListTagResponse;
use App\Dtos\Tag\TagResponse;
use App\Dtos\Tag\UpdateTagRequest;
use App\Services\TagService;

class TagController
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function create(Request $request): Response
    {
        $body = new CreateTagRequest($request->getBody());
        $tag = $this->tagService->create($body);

        $response = new TagResponse($tag);
        return new Response($response, 201);
    }

    public function get(Request $request): Response
    {
        $tag = $this->tagService->findById($request->getVariable("id"));

        $response = new TagResponse($tag);
        return new Response($response, 200);
    }

    public function list(Request $request): Response
    {
        $productId = $request->getQuery("productId");

        if ($productId === null) {
            $tags = $this->tagService->findAll();
        } else {
            $tags = $this->tagService->findByProductId($productId);
        }

        $response = new ListTagResponse($tags);

        return new Response($response);
    }

    public function update(Request $request): Response
    {
        $tag = $this->tagService->update(
            $request->getVariable("id"),
            new UpdateTagRequest($request->getBody())
        );

        $response = new TagResponse($tag);
        return new Response($response);
    }

    public function delete(Request $request): Response
    {
        $tag = $this->tagService->delete($request->getVariable("id"));
        $response = new TagResponse($tag);

        return new Response($response);
    }
}
