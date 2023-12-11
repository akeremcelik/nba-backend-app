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

    public function updateFixture(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function getFixturesByLeague(int $league_id)
    {
        return $this->toQuery()
            ->where('league_id', $league_id)
            ->orderBy('week')
            ->with('homeTeam', 'awayTeam')
            ->get();
    }

    public function getFixturesByLeagueAndWeek(int $league_id, int $week)
    {
        return $this->getFixturesByLeague($league_id)
            ->where('week', $week);
    }

    public function getPlayedFixturesByLeague(int $league_id)
    {
        return $this->getFixturesByLeague($league_id)
            ->where('is_played', true);
    }
}
