<?php
namespace App\Services;
use App\Domain\Product;
use App\Ports\Input\ProductServicePort;
use App\Ports\Output\ProductRepositoryPort;

class ProductService implements ProductServicePort  {

    private ProductRepositoryPort $productRepository;

    public function __construct(ProductRepositoryPort $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function save(Product $product): void
    {
        $nameIsAvailable = $this->productRepository->findByName($product->name) === null;

        if (!$nameIsAvailable) {
            // TODO: add custom exception
            throw new \Error();
        }

        $this->productRepository->save($product);
    }
}