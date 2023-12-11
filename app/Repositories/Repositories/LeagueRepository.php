<?php

namespace App\Repositories\Repositories;

use App\Models\League;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\LeagueInterface;

class LeagueRepository extends BaseRepository implements LeagueInterface
{
    public function __construct(League $model)
    {
        parent::__construct($model);
    }

    public function createLeague(array $data)
    {
        return $this->create($data);
    }

    public function findOrFailLeague(int $id)
    {
        return $this->findOrFail($id);
    }

    public function updateLeague(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function getFixtures(int $id)
    {
        return $this->findOrFail($id)
            ->fixtures()
            ->orderBy('week')
            ->with('homeTeam', 'awayTeam')
            ->get();
    }

    public function getWeeklyFixtures(int $id, int $week)
    {
        return $this->getFixtures($id)
            ->where('week', $week);
    }

    public function getPlayedFixtures(int $id)
    {
        return $this->getFixtures($id)
            ->where('is_played', true);
    }

    public function getScoreboards(int $id)
    {
        return $this->findOrFail($id)
            ->scoreboards()
            ->with('team')
            ->get()
            ->sortBy([
                ['won', 'desc'],
                ['average', 'desc'],
                ['scores_out', 'desc'],
                ['scores_in', 'asc']
            ]);
    }

    public function getTeamScoreboard(int $id, int $team_id)
    {
        return $this->getScoreboards($id)
            ->where('team_id', $team_id)
            ->firstOrFail();
    }
}
