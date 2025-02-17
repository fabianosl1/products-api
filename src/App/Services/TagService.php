<?php
namespace App\Services;

use App\Dtos\Category\CreateCategoryRequest;
use App\Entities\Category;
use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;
use App\Repositories\CategoryRepository;

class TagService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function findById($id): Category
    {
        $category = $this->categoryRepository->findById($id);

        if ($category === null) {
            throw new NotFoundException("category not found");
        }

        return $category;
    }

    public function create(CreateCategoryRequest $createCategoryRequest): Category
    {
        $exist = $this->categoryRepository->findByName($createCategoryRequest->name);

        if ($exist) {
            throw new HttpException("category already exist", 400);
        }

        $category = $createCategoryRequest->toEntity();
        $this->categoryRepository->save($category);

        return $category;
    }

    public function delete(string $categoryId): void
    {
        $category = $this->findById($categoryId);
        $this->categoryRepository->delete($category);
    }

}