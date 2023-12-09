<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function firstOrCreate(array $data1, array $data2)
    {
        return $this->getQuery()->firstOrCreate($data1, $data2);
    }

    public function get()
    {
        return $this->getQuery()->get();
    }
}
