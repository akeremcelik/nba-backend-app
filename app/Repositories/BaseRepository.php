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

    public function toQuery()
    {
        return $this->model->query();
    }

    public function all(array $relations = [])
    {
        return $this->toQuery()->with($relations)->get();
    }

    public function allWithWhere(array $relations = [], array $where = [])
    {
        return $this->toQuery()->where($where)->with($relations)->get();
    }

    public function firstOrCreate(array $data1, array $data2 = [])
    {
        return $this->toQuery()->firstOrCreate($data1, $data2);
    }

    public function create(array $data)
    {
        return $this->toQuery()->create($data);
    }

    public function findOrFail(int $id)
    {
        return $this->toQuery()->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model->fresh();
    }
}
