<?php
namespace App\Repositories;

use App\Entities\Category;

interface CategoryRepository
{
    public function findById(int $id): ?Category;

    public function findByName(string $name): ?Category;

    /**
     * @return Category[]
     */
    public function findAll(): array;

    public function save(Category $category): void;

    public function delete(Category $category): void;

}
