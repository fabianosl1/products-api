<?php
namespace App\Repositories\Impl;

use App\Repositories\TagRepository;
use App\Entities\Tag;
use PDO;

class PostgresTagRepository implements TagRepository
{

    private PDOClient $db;

    public function __construct()
    {
        $this->db = PDOClient::getInstance();
    }

    public function findById($id): ?Tag
    {
        return $this->fetchOne("id", $id);
    }

    public function findByName(string $name): ?Tag
    {
        return $this->fetchOne("name", $name);
    }

    private function fetchOne(string $key, $value): ?Tag
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM tags WHERE $key = ?");
        $stmt->execute([$value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->parse($row);
        }

        return null;
    }

    private function parse(array $row): Tag
    {
        return new Tag(id: $row['id'], name: $row['name']);
    }

    public function findAll(): array
    {
        $stmt = $this->db->getPdo()->query("SELECT * FROM tags");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tags = [];
        foreach ($rows as $row) {
            $tags[] = $this->parse($row);
        }

        return $tags;
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
        $stmt = $this->db->getPdo()->prepare("INSERT INTO tags (name) VALUES (?) RETURNING id");

        $stmt->execute([$tag->getName()]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $tag->setId($row['id']);
    }

    public function update(Tag $tag): void
    {
        $stmt = $this->db->getPdo()->prepare("UPDATE tags set name = ? where id = ?");
        $stmt->execute([$tag->getName(), $tag->getId()]);
    }

    public function delete(Tag $tag): void
    {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM tags WHERE id = ?");
        $stmt->execute([$tag->getId()]);
    }
}