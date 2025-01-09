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

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->categoryRepository->all();
    }

    public function create(CategoryDTO $dto): Category
    {
        return $this->categoryRepository->create([
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
        ]);
    }

    public function update(Category $category, CategoryDTO $dto): Category
    {
        return $this->categoryRepository->update($category, [
            'name' => $dto->name,
            'parent_id' => $dto->parent_id,
        ]);
    }

    public function delete(Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }
}
