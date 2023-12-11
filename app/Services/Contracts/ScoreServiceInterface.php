<?php

namespace App\Services\Contracts;

interface ScoreServiceInterface
{
    public function determineTeamScores(int $homeTeamTotalStrength, int $awayTeamTotalStrength);
}
