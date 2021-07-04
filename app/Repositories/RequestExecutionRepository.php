<?php

namespace App\Repositories;

use App\Models\RequestExecution;

class RequestExecutionRepository extends Repository
{
    /**
     * @var RequestExecution $model
     */
    protected RequestExecution $model;

    public function __construct(RequestExecution $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insertResponseTime(array $data): bool
    {
        $model = new $this->model;

        $model->method = $data['method'];
        $model->path = $data['path'];
        $model->seconds = $data['seconds'];
        $model->ip = $data['ip'];
        $model->user_agent = $data['user_agent'];
        $model->create_user = $data['create_user'];

        $model->save();
        return true;
    }

}

