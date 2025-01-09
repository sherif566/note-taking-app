<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\Repositories\Interfaces\RepositoryInterface;

class CategoryService
{
    private RepositoryInterface $categoryRepository;

    public function __construct(RepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function create(CategoryDTO $dto)
    {
        return $this->categoryRepository->create([
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
        ]);
    }

    public function update(Category $category, CategoryDTO $dto)
    {
        return $this->categoryRepository->update($category, [
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
        ]);
    }

    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category);
    }
}
