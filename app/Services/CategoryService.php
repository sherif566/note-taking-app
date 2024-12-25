<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
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
