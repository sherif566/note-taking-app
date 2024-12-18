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

     // Method to get notes by category name
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
        // Find the note by its ID
        $category = $this->categoryRepository->findById($id);

        // Check if the note exists
        if (!$category) {
            throw new \Exception('Category not found');
        }

        // Pass the note model to the repository's update method
        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory($category)
    {
        return $this->categoryRepository->delete($category);
    }
}
