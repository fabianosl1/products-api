<?php
namespace App\Repositories\Impl;

use App\Repositories\TagRepository;
use App\Entities\Tag;
use PDO;

class PostgresTagRepository implements TagRepository
{

    private PDOClient $database;

    public function __construct()
    {
        $this->database = PDOClient::getInstance();
    }

    public function findById($id): ?Tag
    {
        return $this->fetchOne("id", $id);
    }

    public function findByName(string $name): ?Tag
    {
        return $this->fetchOne("name", $name);
    }

    private function fetchOne(string $key, mixed $value): ?Tag
    {
        $stmt = $this->database->prepare("SELECT * FROM tags WHERE $key = ?");
        $stmt->execute([$value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->parse($row);
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->database->query("SELECT * FROM tags");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->parseMany($rows);
    }

    public function findByProductId(int $productId): array
    {
        $stmt = $this->database->prepare("SELECT t.* FROM tags t JOIN products_tags pt ON t.id = pt.tag_id WHERE pt.product_id = ?");
        $stmt->execute([$productId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->parseMany($rows);
    }

    /**
    * @param mixed[] $rows
    * @@return Tag[]
    */
    private function parseMany(array $rows): array
    {
        $tags = [];
        foreach ($rows as $row) {
            $tags[] = $this->parse($row);
        }

        return $tags;
    }

    private function parse(mixed $row): Tag
    {
        return new Tag(id: $row['id'], name: $row['name']);
    }

    public function save(Tag $tag): void
    {
        if ($tag->getId() === null) {
            $this->create($tag);
        } else {
            $this->update($tag);
        }
    }

    private function create(Tag $tag): void
    {
        $stmt = $this->database->prepare("INSERT INTO tags (name) VALUES (?) RETURNING id");

        $stmt->execute([$tag->getName()]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $tag->setId($row['id']);
    }

    public function update(Tag $tag): void
    {
        $stmt = $this->database->prepare("UPDATE tags set name = ? where id = ?");
        $stmt->execute([$tag->getName(), $tag->getId()]);
    }

    public function delete(Tag $tag): void
    {
        $stmt = $this->database->prepare("DELETE FROM tags WHERE id = ?");
        $stmt->execute([$tag->getId()]);
    }
}
