<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\DTOs\CategorySearchDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}


    public function getAll(CategorySearchDTO $dto): LengthAwarePaginator
    {
        Log::info('Fetching categories with filters.', ['filters' => $dto]);

        $categories = $this->categoryRepository->search($dto);

        Log::info('Fetched categories.', ['categories_count' => $categories->total()]);

        return $categories;
    }




    public function create(CategoryDTO $dto): Category
    {
        Log::info('Creating a new category.', ['data' => $dto->toArray()]);

        $category = $this->categoryRepository->create($dto->toArray());

        Log::info('Category created successfully.', ['category_id' => $category->id]);

        return $category;
    }





    public function update(Category $category, CategoryDTO $dto): Category
    {
        Log::info('Updating category.', ['category_id' => $category->id, 'data' => $dto->toArray()]);

        $updatedCategory = $this->categoryRepository->update($category, $dto->toArray());

        Log::info('Category updated successfully.', ['category_id' => $updatedCategory->id]);

        return $updatedCategory;
    }



    public function delete(Category $category): bool
    {
        Log::info('Deleting category.', ['category_id' => $category->id]);

        $deleted = $this->categoryRepository->delete($category);

        Log::info('Category deleted successfully.', ['category_id' => $category->id, 'status' => $deleted]);

        return $deleted;
    }



    public function search(CategorySearchDTO $dto): LengthAwarePaginator
    {
        Log::info('Searching Categories.', ['filters' => $dto->toArray()]);

        $categories = $this->categoryRepository->search($dto);

        Log::info('Category search successful.', ['categories_count' => $categories->total()]);

        return $categories;
    }
}
