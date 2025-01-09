<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements RepositoryInterface
{
    public function all($perPage = 10): LengthAwarePaginator
    {
        return Category::paginate($perPage);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update($category, array $data): Category
    {
        return tap($category, function ($category) use ($data) {
            $category->update($data);
            Log::info('Category updated', ['category_id' => $category->id]);
        });
    }

    public function delete($category): bool
    {
        return $category->delete();
    }
}
