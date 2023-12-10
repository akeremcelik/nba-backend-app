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

    public function getGroupedFixturesWithRelationsByLeague(int $league_id)
    {
        return $this->toQuery()
            ->where('league_id', $league_id)
            ->orderBy('week')
            ->with('homeTeam', 'awayTeam')
            ->get()
            ->groupBy('week');
    }

    public function getFixturesByLeagueAndWeek(int $league_id, int $week)
    {
        return $this->toQuery()
            ->where(['league_id' => $league_id, 'week' => $week])
            ->get();
    }

    public function getGroupedFixturesWithRelationsByLeagueAndWeek(int $league_id, int $week)
    {
        return $this->toQuery()
            ->where(['league_id' => $league_id, 'week' => $week])
            ->with('homeTeam', 'awayTeam')
            ->get()
            ->groupBy('week');
    }

    public function getPlayedFixturesWithTeams(int $league_id)
    {
        return $this->toQuery()
            ->where(['league_id' => $league_id, 'is_played' => true])
            ->orderBy('week')
            ->with('homeTeam', 'awayTeam')
            ->get()
            ->groupBy('week');
    }
}
