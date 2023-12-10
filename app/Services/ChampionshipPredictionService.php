<?php

namespace App\Services;

use App\Models\League;
use App\Repositories\Contracts\ScoreboardInterface;

class ChampionshipPredictionService
{
    public function __construct(
        protected ScoreboardInterface $scoreboardRepository,
    )
    {
        //
    }

    public function getPredictions(League $league, $scoreboards): array
    {
        $teams = [];
        $remainingWeeks = $league->final_week - $league->at_week;

        if ($remainingWeeks <= 3) {
            $maxWin = $scoreboards->max('won');
            $totalPrediction = 0;

            foreach ($scoreboards as $scoreboard) {
                $team = $scoreboard->team;

                if (($scoreboard->won + $remainingWeeks) < $maxWin) {
                    $team->prediction = 0;
                } else {
                    $prediction = $scoreboard->won + ($scoreboard->average * $remainingWeeks);

                    if ($prediction < 0) {
                        $prediction = 0;
                    }

                    $team->prediction = $prediction;
                    $totalPrediction += $prediction;
                }

                $teams[] = $team;
            }

            foreach ($teams as $team)
            {
                $prediction = ($team->prediction / $totalPrediction) * 100;
                $team->prediction = round($prediction, 2);
            }
        }

        return $teams;
    }
}
