<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryRepository
{
    public function getAll($perPage = 10)
    {
        return Category::paginate($perPage);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        return tap($category, function ($category) use ($data) {
            $category->update($data);

            Log::info('Category updated', ['category_id' => $category->id]);
        });
    }

    public function delete(Category $category)
    {
        $category->delete();
    }
}
