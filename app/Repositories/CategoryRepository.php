<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DTOs\CategorySearchDTO;


class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function update(Model $category, array $data): Category
    {
        Log::debug('Executing category update query');

        if (!($category instanceof Category)) {
            throw new \InvalidArgumentException("Expected instance of Category.");
        }

        return tap($category, function (Category $category) use ($data) {

            $category->update($data);

            Log::debug('Category updated successfully', ['category_id' => $category->id]);
        });


    }

    public function search(CategorySearchDTO $dto): LengthAwarePaginator
    {
        Log::debug('Executing category search query', ['filters' => $dto->toArray()]);

        $query = $this->model->query();

        if ($dto->name) {
            $query->where('name', 'LIKE', "%{$dto->name}%");
        }

        if ($dto->parent_id) {
            $query->where('parent_id', $dto->parent_id);
        }

        Log::debug('Category search query executed successfully');

        return $this->paginate($query);
    }

}
