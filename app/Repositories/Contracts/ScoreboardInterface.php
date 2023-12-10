<?php

namespace App\Repositories\Contracts;

interface ScoreboardInterface
{
    public function createScoreboard(array $data);
    public function updateScoreboard(int $id, array $data);
    public function findScoreboardByLeagueAndTeam(int $league_id, int $team_id);
    public function listScoreboardsByLeagueDescWonAndAverage(int $league_id);
}
