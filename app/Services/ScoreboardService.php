<?php

namespace App\Services;

use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Services\Contracts\ScoreboardServiceInterface;

class ScoreboardService implements ScoreboardServiceInterface
{
    public function __construct(
        protected ScoreboardInterface $scoreboardRepository,
        protected LeagueInterface $leagueRepository
    )
    {
        //
    }

    public function updateHomeTeamScoreboard(int $league_id, int $team_id, array $scores): void
    {
        $scoreboard = $this->leagueRepository->getTeamScoreboard($league_id, $team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['home_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['away_team_score'],
            'average' => $scoreboard->average + ($scores['home_team_score'] - $scores['away_team_score']),
        ];

        if ($scores['home_team_score'] > $scores['away_team_score']) {
            $data['won'] = $scoreboard->won + 1;
        } else {
            $data['lost'] = $scoreboard->lost + 1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }

    public function updateAwayTeamScoreboard(int $league_id, int $team_id, array $scores): void
    {
        $scoreboard = $this->leagueRepository->getTeamScoreboard($league_id, $team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['away_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['home_team_score'],
            'average' => $scoreboard->average + ($scores['away_team_score'] - $scores['home_team_score']),
        ];

        if ($scores['away_team_score'] > $scores['home_team_score']) {
            $data['won'] = $scoreboard->won + 1;
        } else {
            $data['lost'] = $scoreboard->lost + 1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }
}
