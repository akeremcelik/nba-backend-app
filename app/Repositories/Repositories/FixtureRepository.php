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

    public function getFixturesWithRelationsByLeague(int $league_id)
    {
        return $this->allWithWhere(['homeTeam', 'awayTeam'], ['league_id' => $league_id])
            ->groupBy('week')
            ->sortBy(function ($object, $key) {
                return $key;
            });
    }

    public function getFixturesByLeagueAndWeek(int $league_id, int $week)
    {
        return $this->allWithWhere([], ['league_id' => $league_id, 'week' => $week]);
    }

    public function updateFixture(int $id, array $data)
    {
        return $this->update($id, $data);
    }
}
