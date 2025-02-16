<?php
namespace App\Services;
use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\UpdateProductRequest;
use App\Entities\Product;
use App\Exceptions\HttpException;
use App\Repositories\ProductRepository;
use App\Exceptions\NotFoundException;

class ProductService
{
    private ProductRepository $productRepository;

    private CategoryService $categoryService;

    private TagService $tagService;

    public function __construct(ProductRepository $productRepository, CategoryService $categoryService, TagService $tagService)
    {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    public function create(CreateProductRequest $request): Product
    {
        $exist = $this->productRepository->findByName($request->name);

        if ($exist) {
            throw new HttpException("Product with the same name already exist", 400);
        }

        $category = $this->categoryService->findById($request->categoryId);

        $product = $request->toEntity();
        $product->setCategory($category);

        $tags = [];

        foreach ($request->tagsIds as $tag) {
            $tags[]= $this->tagService->findById($tag);
        }

        $product->setTags($tags);

        $this->productRepository->save($product);
        return $product;
    }

    public function update(int $productId, UpdateProductRequest $request): Product
    {
        $product = $this->findById($productId);
        $request->update($product);
        $this->productRepository->save($product);
        return $product;
    }

    /**
     * @return Product[]
     */
    public function listAll(string $orderBy): array
    {
        return $this->productRepository->findAll($orderBy);
    }

    /**
     * @return Product[]
     */
    public function listByCategoryId(int $categoryId): array
    {
        return $this->productRepository->findByCategoryId($categoryId);
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

    public function likeProduct(int $id): Product
    {
        $product = $this->findById($id);
        $product->like();
        $this->productRepository->save($product);
        return $product;
    }
}
