<?php
namespace App\Controllers;

use App\Dtos\Category\CategoryResponse;
use App\Dtos\Category\CreateCategoryRequest;
use App\Dtos\Category\ListCategoryResponse;
use App\Dtos\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Router\Request;
use Router\Response;

class CategoryController implements BaseController
{
    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(Request $request): Response
    {
        $body = new CreateCategoryRequest($request->getBody());
        $category = $this->categoryService->create($body);

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function get(Request $request): Response
    {
        $category = $this->categoryService->findById($request->getVariable("id"));

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function update(Request $request): Response
    {
        $body = new UpdateCategoryRequest($request->getBody());
        $category = $this->categoryService->update($request->getVariable("id"), $body);

        $response = new CategoryResponse($category);
        return new Response($response);
    }

    public function list(Request $request): Response
    {
        $categories = $this->categoryService->findAll();
        $response = new ListCategoryResponse($categories);
        return new Response($response);
    }

    public function delete(Request $request): Response
    {
        $category = $this->categoryService->delete($request->getVariable("id"));
        $response = new CategoryResponse($category);
        return new Response($response);
    }
}
