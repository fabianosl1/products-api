<?php

namespace App\Repositories\Impl;

use App\Entities\Product;
use App\Repositories\ProductRepository;
use PDO;

class PostgresProductRepository implements ProductRepository
{

    private PDOClient $db;

    public function __construct()
    {
        $this->db = PDOClient::getInstance();
    }

    public function findById($id): ?Product
    {
        return $this->fetchOne("id", $id);
    }

    public function findByName(string $name): ?Product
    {
        return $this->fetchOne("name", $name);
    }

    private function fetchOne(string $key, $value): ?Product
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM products WHERE $key = ?");
        $stmt->execute([$value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->parse($row);
        }

        return null;
    }

    public function findAll(?string $orderBy): array
    {
        $stmt = $this->db->getPdo()->query("SELECT * FROM products ORDER BY $orderBy ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->parseMany($rows);
    }

    public function findByCategory(int $categoryId): array
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->parseMany($rows);
    }

    private function parseMany(array $rows): array
    {
        $result = [];

        foreach ($rows as $row) {
            $result[]= $this->parse($row);
        }

        return $result;
    }

    private function parse($row): Product
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

    public function update(Product $product): void
    {
        $stmt = $this->db->getPdo()->prepare("UPDATE products set name = ?, description = ?, price = ?, likes = ?, category_id = ? where id = ? RETURNING *");
        $stmt->execute([$product->getName(), $product->getDescription(), $product->getPrice(), $product->getLikes(), $product->getCategoryId(), $product->getId()]);
    }

    private function create(Product $product): void
    {
        $stmt = $this->db->getPdo()->prepare("INSERT INTO products (name, description, price, likes, category_id) VALUES (?, ?, ?, ?, ?) RETURNING id, price");

        $stmt->execute([$product->getName(), $product->getDescription(), $product->getPrice(), $product->getLikes(), $product->getCategory()->getId()]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $product->setId($row['id']);
        $product->setPrice($row['price']);
    }

    public function delete(Product $product): void
    {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product->getId()]);
    }


}