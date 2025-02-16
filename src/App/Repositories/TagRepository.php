<?php
namespace App\Repositories;

use App\Entities\Tag;

interface TagRepository
{
    public function findById(int $id): ?Tag;

    public function findByName(string $name): ?Tag;

    /**
     * @return Tag[]
     */
    public function findAll(): array;

    /**
     * @return Tag[]
     */
    public function findByProductId(int $productId): array;

    public function save(Tag $tag): void;

    public function delete(Tag $tag): void;

}
