<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    // Get notes by category name
    public function getNotesByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();

        // Return the category if found, otherwise return null
        return $category ? $category->notes : null;
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        $category->delete();
        return true;
    }
}
