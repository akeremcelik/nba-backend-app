<?php

namespace App\Repositories\Repositories;

use App\Models\Fixture;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\FixtureInterface;
use Illuminate\Database\Eloquent\Model;

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

    public function listFixtures()
    {
        return $this->getQuery()->with(['homeTeam', 'awayTeam'])->get();
    }

    public function deleteFixtures()
    {
        return $this->delete();
    }
}
