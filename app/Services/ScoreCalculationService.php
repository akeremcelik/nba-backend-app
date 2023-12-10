<?php

namespace App\Services;

class ScoreCalculationService
{
    public function determineTeamScores(int $homeTeamTotalStrength, int $awayTeamTotalStrength): array
    {
        if ($homeTeamTotalStrength === $awayTeamTotalStrength) {
            // avoid draw
            random_int(0, 1) === 0 ? $homeTeamTotalStrength+=1 : $awayTeamTotalStrength+=1;
        }

        $randomScore = random_int(80, 100);
        $homeTeamScore = $randomScore;
        $awayTeamScore = $randomScore;

        if ($homeTeamTotalStrength > $awayTeamTotalStrength) {
            $homeTeamScore = $awayTeamScore + random_int(1, ($homeTeamTotalStrength - $awayTeamTotalStrength));
        } elseif ($homeTeamTotalStrength < $awayTeamTotalStrength) {
            $awayTeamScore = $homeTeamScore + random_int(1, ($awayTeamTotalStrength - $homeTeamTotalStrength));
        }

        return [
            'home_team_score' => $homeTeamScore,
            'away_team_score' => $awayTeamScore
        ];
    }
}
