<?php

namespace App\Repositories\Repositories;

use App\Models\Fixture;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\FixtureInterface;

class FixtureRepository extends BaseRepository implements FixtureInterface
{
    public function __construct(Fixture $model)
    {
        parent::__construct($model);
    }

    public function createFixture(array $data)
    {
        return $this->create($data);
    }

    public function updateFixture(int $id, array $data)
    {
        return $this->update($id, $data);
    }
}
