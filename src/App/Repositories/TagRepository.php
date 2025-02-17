<?php
namespace App\Repositories;

use App\Entities\Tag;

interface TagRepository
{
    public function findById($id): ?Tag;

    public function findByName(string $name);

    /**
     * @return Tag[]
     */
    public function findAll(): array;

    public function save(Tag $tag): void;

    public function delete(Tag $tag): void;

}