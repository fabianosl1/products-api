<?php
namespace App\Application\Services;
use App\Domain\Product;
use App\Domain\ProductRepository;

class ProductService
{

    private ProductRepository $productRepository;

    public function __construct()
    {

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

    public function findById(int $id): string {
        return "DI work";
    }
}