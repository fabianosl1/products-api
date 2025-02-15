<?php
namespace App\Controllers;

use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\ListProductResponse;
use App\Exceptions\HttpException;
use App\Services\ProductService;
use App\Dtos\Product\ProductResponse;
use App\Dtos\Response;

class ProductController implements BaseController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create($request): Response
    {
        $body = new CreateProductRequest($request["body"]);
        $product = $this->productService->create($body);
        $response = new ProductResponse($product);

        return new Response($response, 201);
    }

    public function get($request): Response
    {
        $product = $this->productService->findById($request["variables"]["id"]);
        $response = new ProductResponse($product);
        return new Response($response);
    }

    public function update($request): Response
    {
        $product = $this->productService->update(
            $request["variables"]["id"],
            $request["body"]
        );

        $response = new ProductResponse($product);
        return new Response($response);
    }

    public function list($request): Response
    {
        $available = ["name", "price", "likes"];
        $orderBy = $request["params"]["orderBy"] ?? "name";

        if (!in_array($orderBy, $available, true)) {
            throw new HttpException("invalid 'orderBy' parameter", 400);
        }

        $products = $this->productService->listAll($orderBy);
        $response = new ListProductResponse($products);
        return new Response($response);
    }

    public function delete($request): Response
    {
        $product = $this->productService->delete($request["variables"]["id"]);
        $response = new ProductResponse($product);
        return new Response($response);
    }
}