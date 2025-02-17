<?php
namespace App\Services;
use App\Dtos\Product\CreateProductRequest;
use App\Dtos\Product\UpdateProductRequest;
use App\Entities\Product;
use App\Exceptions\HttpException;
use App\Logger;
use App\Repositories\ProductRepository;
use App\Exceptions\NotFoundException;

class ProductService
{
    private Logger $logger;

    private ProductRepository $productRepository;

    private CategoryService $categoryService;

    private TagService $tagService;

    public function __construct(ProductRepository $productRepository, CategoryService $categoryService, TagService $tagService)
    {
        $this->logger = new Logger(self::class);
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    public function create(CreateProductRequest $request): Product
    {
        $exist = $this->productRepository->findByName($request->name);

        if ($exist !== null) {
            $this->logger->info("Product name:$request->name already exist");
            throw new HttpException("Product with the same name already exist", 400);
        }

        $category = $this->categoryService->findById($request->categoryId);

        $product = $request->toEntity();
        $product->setCategory($category);

        $this->fetchTags($product, $request->tagsIds);

        $this->productRepository->save($product);
        return $product;
    }
    /**
     * @param int[] $tagsIds
     */
    public function associateTags(int $productId, array $tagsIds): Product
    {
        $product = $this->findById($productId);
        $this->fetchTags($product, $tagsIds);
        $this->productRepository->save($product);
        return $product;
    }
    /**
     * @param int[] $tagsIds
     * @return Tags[]
     */
     private function fetchTags(Product $product, array $tagsIds): void
     {
         $map = [];
         $tags = $product->getTags();

         foreach ($tags as $tag) {
            $map[$tag->getId()] = $tag;
        }

        foreach ($tagsIds as $tagId) {
            $stored = $map[$tagId] ?? null;

            if ($stored === null) {
                $tags[]= $this->tagService->findById($tagId);
            }
        }

        $product->setTags($tags);
    }

    public function update(int $productId, UpdateProductRequest $request): Product
    {
        $product = $this->findById($productId);
        $request->update($product);

        if ($request->categoryId !== null) {
            $category = $this->categoryService->findById($request->categoryId);
            $product->setCategory($category);
        }

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
            $this->logger->info("product id:$id not found");
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
