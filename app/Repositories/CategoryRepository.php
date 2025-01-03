<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements RepositoryInterface
{
    public function all($perPage = 10)
    {
        return Category::paginate($perPage);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($category, array $data)
    {
        return tap($category, function ($category) use ($data) {
            $category->update($data);
            Log::info('Category updated', ['category_id' => $category->id]);
        });
    }

    public function delete($category)
    {
        $category->delete();
    }
}
