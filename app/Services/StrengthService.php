<?php

namespace App\Services;

use App\Models\Team;

class StrengthService
{
    const HOME_CONSTANT = 1.5;
    const AWAY_CONSTANT = 1.0;
    const RANDOM_STRENGTH_CONSTANT = 50;

    public function calculateHomeTeamStrength(Team $homeTeam): float|int
    {
        $strength = [
            'team' => $homeTeam->team_strength,
            'location' => self::HOME_CONSTANT * $homeTeam->home_strength,
            'random' => random_int(0, self::RANDOM_STRENGTH_CONSTANT)
        ];

        return array_sum($strength);
    }

    public function calculateAwayTeamStrength(Team $awayTeam): float|int
    {
        $strength = [
            'team' => $awayTeam->team_strength,
            'location' => self::AWAY_CONSTANT * $awayTeam->away_strength,
            'random' => random_int(0, self::RANDOM_STRENGTH_CONSTANT)
        ];

        return array_sum($strength);
    }
}
