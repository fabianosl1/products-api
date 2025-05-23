<?php
namespace App\Controllers;

use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\ListProductResponse;
use App\Dtos\Product\UpdateProductRequest;
use App\Exceptions\HttpException;
use App\Services\ProductService;
use App\Dtos\Product\ProductResponse;
use Router\Response;
use Router\Request;

class ProductController
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

    public function associateTags(Request $request): Response
    {
        $body = $request->getBody();
        $productId = $request->getVariable("id");

        $product = $this->productService->associateTags($productId, $body["tagsIds"]);
        $response = new ProductResponse($product);

        return new Response($response);
    }

    public function get(Request $request): Response
    {
        $product = $this->productService->findById($request->getVariable("id"));
        $response = new ProductResponse($product);
        return new Response($response);
    }

    public function update(Request $request): Response
    {
        $body = new UpdateProductRequest($request->getBody());

        $product = $this->productService->update(
            $request->getVariable("id"),
            $body
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

    public function like(Request $request): Response
    {
        $product = $this->productService->likeProduct($request->getVariable("id"));
        $response = new ProductResponse($product);
        return new Response($response);
    }
}
