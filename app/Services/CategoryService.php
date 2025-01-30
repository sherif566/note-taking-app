<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\DTOs\CategorySearchDTO;
use App\Repositories\Interfaces\CRUDInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    private CRUDInterface $categoryRepository;

    public function __construct(CRUDInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(): LengthAwarePaginator
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

    public function searchCategories(CategorySearchDTO $dto): LengthAwarePaginator
    {
        return $this->categoryRepository->search(
            $dto->toArray(),
            $dto->per_page,
            $dto->page
        );
    }
}
