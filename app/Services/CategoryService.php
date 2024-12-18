<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

     public function getNotesByCategory($categoryName)
     {
         return $this->categoryRepository->getNotesByCategory($categoryName);
     }

    public function findCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new \Exception('Category not found');
        }

        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory($category)
    {
        return $this->categoryRepository->delete($category);
    }
}
