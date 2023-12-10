<?php

namespace App\Repositories\Repositories;

use App\Models\Scoreboard;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ScoreboardInterface;
use Illuminate\Database\Eloquent\Model;

class ScoreboardRepository extends BaseRepository implements ScoreboardInterface
{
    public function __construct(Scoreboard $model)
    {
        parent::__construct($model);
    }

    public function createScoreboard(array $data)
    {
        return $this->create($data);
    }

    public function findScoreboardByLeagueAndTeam(int $league_id, int $team_id)
    {
        return $this->firstOrFail(['league_id' => $league_id, 'team_id' => $team_id]);
    }

    public function updateScoreboard(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function listScoreboardsByLeagueDescWonAndAverage(int $league_id)
    {
        return $this->allWithWhere([], ['league_id' => $league_id])->sortByDesc('won, average');
    }
}
