<?php
namespace App\Controllers;

use App\Dtos\Product\ListProductResponse;
use App\Services\ProductService;
use App\Dtos\Product\ProductResponse;
use App\Dtos\Response;


class ProductController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create($request): Response
    {
        $product = $this->productService->create($request);
        $response = new ProductResponse($product);
        return new Response($response);
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
        $products = $this->productService->listAll($request["params"]["orderBy"]);
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