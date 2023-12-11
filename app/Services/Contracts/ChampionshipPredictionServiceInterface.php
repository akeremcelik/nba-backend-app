<?php

namespace App\Services\Contracts;

use App\Models\League;

interface ChampionshipPredictionServiceInterface
{
    public function getPredictions(League $league, $scoreboards);
}
