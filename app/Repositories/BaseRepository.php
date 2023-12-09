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

    public function all()
    {
        return $this->getQuery()->get();
    }

    public function create($data)
    {
        return $this->getQuery()->create($data);
    }
}
