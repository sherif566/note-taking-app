<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function update(Model $category, array $data): Category
    {
        if (!($category instanceof Category)) {
            throw new \InvalidArgumentException("Expected instance of Category.");
        }

        return tap($category, function (Category $category) use ($data) {
            $category->update($data);
            Log::info('Category updated', ['category_id' => $category->id]);
        });
    }
}
