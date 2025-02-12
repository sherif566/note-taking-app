<?php

namespace App\Repositories;
use App\Repositories\Interfaces\CRUDInterface;
use App\Utilities\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DTOs\PaginationDTO;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements CRUDInterface

{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($perPage = Constants::DEFAULT_PAGINATION): LengthAwarePaginator
    {
        Log::debug('Fetching all records with pagination from database');

        $result = $this->model->paginate($perPage);

        Log::debug('Fetched records count from database', ['count' => $result->total()]);

        return $result;
    }


    public function create(array $data): Model
    {
        Log::debug('Creating a new record in database', ['data' => $data]);

        $model = $this->model->create($data);

        Log::debug('Record created successfully in database', ['id' => $model->id]);

        return $model;
    }



    public function update(Model $model, array $data): Model
    {
        Log::debug('Updating record in database', ['id' => $model->id, 'data' => $data]);

        return tap($model, function (Model $model) use ($data) {
            $model->update($data);

            Log::debug('Record updated successfully in database', ['id' => $model->id]);
        });
    }



    public function delete(Model $model): bool
    {
        Log::debug('Deleting record from database', ['id' => $model->id]);

        $deleted = $model->delete();

        Log::debug('Record deleted from database', ['id' => $model->id, 'success' => $deleted]);
        return $deleted;
    }



    public function paginate($query): LengthAwarePaginator
    {
        $pagination = new PaginationDTO();

        Log::debug('Applying pagination on database results', [
            'per_page' => $pagination->per_page,
            'page' => $pagination->page
        ]);

        $result = $query->paginate(
            $pagination->per_page,
            ['*'],
            'page',
            $pagination->page
        );

        Log::debug('Pagination applied on database results', ['total_results' => $result->total()]);
        return $result;
    }



}
