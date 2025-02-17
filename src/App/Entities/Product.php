<?php

namespace App\Entities;


class Product extends Entity
{
    private int|null $id;

    private string $name;

    private string $description;

    private float $price;

    private int $likes;

    private int $categoryId;

    private Category $category;

    /**
     * Summary of tags
     * @var Tag[]
     */
    private array $tags = [];

    public function __construct(
        string $name,
        string $description,
        float $price,
        int $categoryId,
        int $likes = 0,
        int|null $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->likes = $likes;
        $this->categoryId = $categoryId;
    }

    public function like(): void
    {
        $this->likes++;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @@return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
    /**
     * @@param Tag[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
}
