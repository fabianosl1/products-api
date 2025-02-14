<?php

namespace App\Entities;


class Product extends Entity
{
    private int|null $id;

    private string $name;

    private string $description;

    private string $price;

    private Category|null $category;

    /**
     * Summary of tags
     * @var Tag[]
     */
    private array|null $tags;

    public function __construct(
        string $name,
        string $description,
        string $price,
        Category $category = null,
        array $tags  = null,
        int|null $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->tags = $tags;
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

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getTags()
    {
        return $this->tags;
    }
}