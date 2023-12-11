<?php

namespace App\Services;

use App\Models\League;
use App\Services\Contracts\ChampionshipPredictionServiceInterface;

class ChampionshipPredictionService implements ChampionshipPredictionServiceInterface
{
    const REMAINING_WEEKS = 3;
    const WIN_CONSTANT = 20;
    const LOSE_CONSTANT = 5;
    const NEGATIVE_PREDICTION_CONSTANT = 5;

    public function getPredictions(League $league, $scoreboards): array
    {
        $teams = [];
        $remainingWeeks = $league->final_week - $league->at_week;

        if ($remainingWeeks > self::REMAINING_WEEKS) {
            return $scoreboards->pluck('team')->toArray();
        } elseif ($remainingWeeks > 0) {
            $result = $this->calculatePredictions($scoreboards, $remainingWeeks);

            $teams = $result['teams'];
            $totalPrediction = $result['totalPrediction'];

            foreach ($teams as $team) {
                $prediction = ($team->prediction / $totalPrediction) * 100;
                $team->prediction = round($prediction, 2);
            }
        }

        return $teams;
    }

    private function calculatePredictions($scoreboards, $remainingWeeks): array
    {
        $teams = [];
        $totalPrediction = 0;
        $maxWin = $scoreboards->max('won');

        foreach ($scoreboards as $scoreboard) {
            $team = $scoreboard->team;

            if (($scoreboard->won + $remainingWeeks) < $maxWin) {
                $team->prediction = 0;
            } else {
                $prediction = ($scoreboard->won * self::WIN_CONSTANT) -
                    ($scoreboard->lost * self::LOSE_CONSTANT) +
                    ($scoreboard->average / 3);

                if ($prediction < 0) {
                    $prediction = self::NEGATIVE_PREDICTION_CONSTANT;
                }

                $team->prediction = $prediction;
                $totalPrediction += $prediction;
            }

            $teams[] = $team;
        }

        return [
            'teams' => $teams,
            'totalPrediction' => $totalPrediction
        ];
    }
}
