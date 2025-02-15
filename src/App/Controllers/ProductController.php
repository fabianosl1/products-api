<?php
namespace App\Controllers;

use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\ListProductResponse;
use App\Exceptions\HttpException;
use App\Services\ProductService;
use App\Dtos\Product\ProductResponse;
use Router\Response;
use Router\Request;

class ProductController implements BaseController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(Request $request): Response
    {
        $body = new CreateProductRequest($request->getBody());
        $product = $this->productService->create($body);
        $response = new ProductResponse($product);

        return new Response($response, 201);
    }

    public function get(Request $request): Response
    {
        $product = $this->productService->findById($request->getVariable("id"));
        $response = new ProductResponse($product);
        return new Response($response);
    }

    public function update(Request $request): Response
    {
        $product = $this->productService->update(
            $request->getVariable("id"),
            $request->getBody()
        );

        $response = new ProductResponse($product);
        return new Response($response);
    }

    public function list(Request $request): Response
    {
        $available = ["name", "price", "likes"];
        $orderBy = $request->getQuery("orderBy") ?? "name";

        if (!in_array($orderBy, $available, true)) {
            throw new HttpException("invalid 'orderBy' parameter", 400);
        }

        $products = $this->productService->listAll($orderBy);
        $response = new ListProductResponse($products);
        return new Response($response);
    }

    public function delete(Request $request): Response
    {
        $product = $this->productService->delete($request->getVariable("id"));
        $response = new ProductResponse($product);
        return new Response($response);
    }
}
