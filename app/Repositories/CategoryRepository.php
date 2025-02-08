<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


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
    public function search(array $filters = [], int $perPage, int $page): LengthAwarePaginator
    {
        unset($filters['per_page'], $filters['page']);

        $query = $this->model->query();

        foreach ($filters as $column => $value) {
            if ($value !== null) {
                if (in_array($column, ['parent_id'])) {
                    $query->where($column, $value);
                } else {
                    $query->where($column, 'LIKE', "%{$value}%");
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
