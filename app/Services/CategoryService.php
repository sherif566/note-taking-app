<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\DTOs\CategorySearchDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\CategoryRepository;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->categoryRepository->all();
    }

    public function create(CategoryDTO $dto): Category
    {
        return $this->categoryRepository->create($dto->toArray());
    }

    public function update(Category $category, CategoryDTO $dto): Category
    {
        return $this->categoryRepository->update($category, $dto->toArray());

    }

    public function delete(Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }

    public function search(CategorySearchDTO $dto): LengthAwarePaginator
    {
        return $this->categoryRepository->search($dto);
    }
}
