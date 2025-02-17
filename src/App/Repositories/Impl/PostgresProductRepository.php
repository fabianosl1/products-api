<?php

namespace App\Repositories\Impl;

use App\Entities\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use Exception;
use PDO;

class PostgresProductRepository implements ProductRepository
{

    private PDOClient $database;

    private TagRepository $tagRepository;

    private CategoryRepository $categoryRepository;

    public function __construct(TagRepository $tagRepository, CategoryRepository $categoryRepository)
    {
        $this->database = PDOClient::getInstance();
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function findById($id): ?Product
    {
        return $this->fetchOne("id", $id);
    }

    public function findByName(string $name): ?Product
    {
        return $this->fetchOne("name", $name);
    }

    private function fetchOne(string $key, mixed $value): ?Product
    {
        $stmt = $this->database->prepare("SELECT * FROM products WHERE $key = ?");
        $stmt->execute([$value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $product = $this->parse($row);

            $tags = $this->tagRepository->findByProductId($product->getId());
            $product->setTags($tags);

            $category = $this->categoryRepository->findById($product->getCategoryId());
            $product->setCategory($category);

            return $product;
        }

        return null;
    }

    public function findAll(?string $orderBy): array
    {
        $stmt = $this->database->query("SELECT * FROM products ORDER BY $orderBy ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->parseMany($rows);
    }
    /**
     * @return Product[]
     */
    public function findByCategoryId(int $categoryId): array
    {
        $stmt = $this->database->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->parseMany($rows);
    }
    /**
     * @return Product[]
     */
    private function parseMany(mixed $rows): array
    {
        $result = [];

        foreach ($rows as $row) {
            $result[]= $this->parse($row);
        }

        return $result;
    }

    private function parse(mixed $row): Product
    {
        return new Product(
            name: $row["name"],
            description: $row["description"],
            price: $row["price"],
            categoryId: $row["category_id"],
            likes: $row["likes"],
            id: $row['id'],
        );
    }

    public function save(Product $product): void
    {
        if ($product->getId() === null) {
            $this->create($product);
        } else {
            $this->update($product);
        }
    }

    private function create(Product $product): void
    {
        try {
            $this->database->beginTransaction();
            $stmt = $this->database->prepare("INSERT INTO products (name, description, price, likes, category_id) VALUES (?, ?, ?, ?, ?) RETURNING id, price");
            $stmt->execute([$product->getName(), $product->getDescription(), $product->getPrice(), $product->getLikes(), $product->getCategory()->getId()]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $product->setId($row['id']);
            $product->setPrice($row['price']);

            foreach ($product->getTags() as $tag) {
                $stmtTag = $this->database->prepare("INSERT INTO products_tags (product_id, tag_id) VALUES (?, ?)");
                $stmtTag->execute([$product->getId(), $tag->getId()]);
            }

            $this->database->commit();
        } catch (Exception $exception) {
            $this->database->rollBack();
            throw $exception;
        }
   }

   public function update(Product $product): void
   {
       try {
           $this->database->beginTransaction();
           $stmt = $this->database->prepare("UPDATE products set name = ?, description = ?, price = ?, likes = ?, category_id = ? where id = ?");
           $stmt->execute([$product->getName(), $product->getDescription(), $product->getPrice(), $product->getLikes(), $product->getCategoryId(), $product->getId()]);

           foreach ($product->getTags() as $tag) {
               $stmtTag = $this->database->prepare("INSERT INTO products_tags (product_id, tag_id) VALUES (?, ?) ON CONFLICT (product_id, tag_id) DO NOTHING");
               $stmtTag->execute([$product->getId(), $tag->getId()]);
           }

           $this->database->commit();
       } catch (Exception $exception) {
           $this->database->rollBack();
           throw $exception;
       }
   }

    public function delete(Product $product): void
    {
        $stmt = $this->database->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product->getId()]);
    }
}
