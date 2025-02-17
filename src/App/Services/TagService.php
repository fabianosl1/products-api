<?php
namespace App\Services;

use App\Dtos\Tag\CreateTagRequest;
use App\Dtos\Tag\UpdateTagRequest;
use App\Entities\Tag;
use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;

use App\Logger;
use App\Repositories\TagRepository;

class TagService
{
    private Logger $logger;

    private TagRepository $tagRepository;

    public function __construct(TagRepository $categoryRepository)
    {
        $this->logger = new Logger(self::class);
        $this->tagRepository = $categoryRepository;
    }

    /**
     * @return Tag[]
     */
    public function findAll(): array
    {
        return $this->tagRepository->findAll();
    }
    /**
     * @return Tag[]
     */
    public function findByProductId(int $productId): array
    {
        return $this->tagRepository->findByProductId($productId);
    }

    public function findById(int $id): Tag
    {
        $tag = $this->tagRepository->findById($id);

        if ($tag === null) {
            $this->logger->info("tag id:$id not found");
            throw new NotFoundException("tag not found");
        }

        return $tag;
    }

    public function create(CreateTagRequest $request): Tag
    {
        $exist = $this->tagRepository->findByName($request->name);

        if ($exist !== null) {
            $this->logger->info("tag name:$request->name already exist");
            throw new HttpException("tag already exist", 400);
        }

        $tag = $request->toEntity();
        $this->tagRepository->save($tag);

        return $tag;
    }

    public function update(int $id, UpdateTagRequest $request): Tag
    {
        $tag = $this->findById($id);

        $request->update($tag);
        $this->tagRepository->save($tag);

        return $tag;
    }

    public function delete(int $tagId): Tag
    {
        $tag = $this->findById($tagId);
        $this->tagRepository->delete($tag);
        return $tag;
    }

}
