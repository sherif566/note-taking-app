<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function all($perPage = 10);
    public function create(array $data);
    public function update($model, array $data);
    public function delete($model);
}
