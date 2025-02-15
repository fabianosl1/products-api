<?php
namespace App\Controllers;

use App\Dtos\Category\CategoryResponse;
use App\Dtos\Category\CreateCategoryRequest;
use App\Dtos\Category\ListCategoryResponse;
use App\Dtos\Category\UpdateCategoryRequest;
use App\Dtos\Response;
use App\Services\CategoryService;

class CategoryController implements BaseController
{
    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create($request): Response
    {
        $body = new CreateCategoryRequest($request["body"]);
        $category = $this->categoryService->create($body);

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function get($request): Response
    {
        $category = $this->categoryService->findById($request["variables"]["id"]);

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function update($request): Response
    {
        $body = new UpdateCategoryRequest($request["body"]);
        $category = $this->categoryService->update($request["variables"]["id"], $body);

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function list($request): Response
    {
        $categories = $this->categoryService->findAll();
        $response = new ListCategoryResponse($categories);
        return new Response($response);
    }

    public function delete($request): Response
    {
        $category = $this->categoryService->delete($request["variables"]["id"]);
        $response = new CategoryResponse($category);
        return new Response($response);
    }
}