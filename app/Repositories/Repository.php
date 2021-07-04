<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @param array $data
     * @return bool
     *
     * @todo when user model::query(), cast columns if possible
     */
    protected function insert(array $data): bool
    {
        /**
         * @var Model $model
         */
        $model = $this->model;
        return $model::query()->insert($data);
    }
}
