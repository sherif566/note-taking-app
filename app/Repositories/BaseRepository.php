<?php

namespace App\Repositories;
use App\Repositories\Interfaces\CRUDInterface;
use App\Utilities\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\DTOs\PaginationDTO;
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

    protected function paginate($query, PaginationDTO $paginationDTO): LengthAwarePaginator
    {
        return $query->paginate($paginationDTO->per_page, ['*'], 'page', $paginationDTO->page);
    }

}
