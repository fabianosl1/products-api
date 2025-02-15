<?php

namespace App\Entities;

class Tag
{

    private int|null $id;

    private string $name;

    public function __construct(int|null $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $param): void
    {
        $this->name = $param;
    }

    public function setId(mixed $id): void
    {
        $this->id = $id;
    }
}