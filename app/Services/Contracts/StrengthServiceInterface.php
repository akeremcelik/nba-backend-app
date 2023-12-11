<?php

namespace App\Services\Contracts;

use App\Models\Team;

interface StrengthServiceInterface
{
    public function calculateHomeTeamStrength(Team $homeTeam);
    public function calculateAwayTeamStrength(Team $awayTeam);
}
