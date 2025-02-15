<?php

namespace App\Repositories\Impl;

use App\Repositories\CategoryRepository;
use App\Entities\Category;
use PDO;

class PostgresCategoryRepository implements CategoryRepository
{

    private PDOClient $db;

    public function __construct()
    {
        $this->db = PDOClient::getInstance();
    }

    public function findById($id): ?Category
    {
        return $this->fetchOne("id", $id);
    }


    public function findByName(string $name): ?Category
    {
        return $this->fetchOne("name", $name);
    }

    private function fetchOne(string $key, $value): ?Category
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM categories WHERE $key = ?");
        $stmt->execute([$value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->parse($row);
        }

        return null;
    }

    private function parse(array $row): Category
    {
        return new Category(id: $row['id'], name: $row['name']);
    }

    public function findAll(): array
    {
        $stmt = $this->db->getPdo()->query("SELECT * FROM categories");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($rows as $row) {
            $categories[] = $this->parse($row);
        }

        return $categories;
    }

    public function save(Category $category): void
    {
        if ($category->getId() === null) {
            $this->create($category);
        } else {
            $this->update($category);
        }
    }

    private function create(Category $category): void
    {
        $stmt = $this->db->getPdo()->prepare("INSERT INTO categories (name) VALUES (?) RETURNING id");

        $stmt->execute([$category->getName()]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $category->setId($row['id']);
    }

    public function update(Category $cate): void
    {
        $stmt = $this->db->getPdo()->prepare("UPDATE categories set name = ? where id = ?");
        $stmt->execute([$cate->getName(), $cate->getId()]);
    }

    public function delete(Category $category): void
    {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$category->getId()]);
    }
}