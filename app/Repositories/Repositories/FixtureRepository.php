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

    public function listFixturesByLeagueId(int $league_id)
    {
        return $this->model::leagueId($league_id)
            ->with(['homeTeam', 'awayTeam'])
            ->get();
    }

    public function listFixturesByLeagueIdAndWeek(int $league_id, int $week)
    {
        return $this->model::leagueId($league_id)
            ->week($week)
            ->get();
    }

    public function updateFixture(int $id, array $data)
    {
        return $this->update($id, $data);
    }
}