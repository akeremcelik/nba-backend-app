<?php

namespace App\Services\Contracts;

interface ScoreboardServiceInterface
{
    public function updateHomeTeamScoreboard(int $league_id, int $team_id, array $scores);
    public function updateAwayTeamScoreboard(int $league_id, int $team_id, array $scores);
}
