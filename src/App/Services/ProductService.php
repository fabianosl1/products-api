<?php
namespace App\Services;
use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\UpdateProductRequest;
use App\Entities\Product;
use App\Repositories\ProductRepository;
use App\Exceptions\NotFoundException;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(CreateProductRequest $request): Product
    {
        $product = $request->toEntity();
        return $product;
    }

    public function update(int $productId, UpdateProductRequest $request): Product {
        return $request->toEntity();
    }

    /**
     * @return Product[]
     */
    public function listAll(string $orderBy): array
    {
        return $this->productRepository->findAll($orderBy);
    }

    public function findById(int $id): Product
    {
        $product = $this->productRepository->findById($id);

        if ($product === null) {
            throw new NotFoundException("Product not found");
        }

        return $product;
    }

    public function delete(int $id): Product
    {
        $product = $this->findById($id);

        $this->productRepository->delete($product);

        return $product;
    }
}