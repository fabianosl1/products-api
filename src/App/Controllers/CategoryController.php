<?php
namespace App\Controllers;

use App\Dtos\Category\CategoryResponse;
use App\Dtos\Category\CreateCategoryRequest;
use App\Dtos\Category\ListCategoryResponse;
use App\Dtos\Category\UpdateCategoryRequest;
use App\Dtos\Product\ListProductResponse;
use App\Services\CategoryService;
use App\Services\ProductService;
use Router\Request;
use Router\Response;

class CategoryController
{
    private CategoryService $categoryService;

    private ProductService $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
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

    public function listProducts(Request $request): Response
    {
        $categoryId = $request->getVariable("id");
        $this->categoryService->findById($categoryId);
        $products = $this->productService->listByCategoryId($categoryId);

        $response = new ListProductResponse($products);

        return new Response($response);
    }

    public function delete(Request $request): Response
    {
        $category = $this->categoryService->delete($request->getVariable("id"));
        $response = new CategoryResponse($category);
        return new Response($response);
    }
}
