<?php

namespace App\Repositories;
use App\Repositories\Interfaces\CRUDInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements CRUDInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($perPage = 10): LengthAwarePaginator
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
}
