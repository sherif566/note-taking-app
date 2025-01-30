<?php

namespace App\Repositories;
use App\Repositories\Interfaces\CRUDInterface;
use App\Utilities\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements CRUDInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($perPage = Constants::DEFAULT_PAGINATION): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        return tap($model, function (Model $model) use ($data) {
            $model->update($data);
        });
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function search(array $filters = [], int $perPage, int $page): LengthAwarePaginator
    {
        unset($filters['per_page'], $filters['page']);

        $query = $this->model->query();

        foreach ($filters as $column => $value) {
            if ($value !== null) {
                if (in_array($column, ['category_id', "parent_id"])) {
                    $query->where($column, $value);
                } else {
                    $query->where($column, 'LIKE', "%{$value}%");
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

}
