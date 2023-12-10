<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
use App\Models\League;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Services\ChampionshipPredictionService;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function __construct(
        protected ScoreboardInterface $scoreboardRepository,
        protected ChampionshipPredictionService $championshipPredictionService,
    )
    {
        //
    }

    public function listScoreboard(League $league): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $scoreboards = $this->scoreboardRepository->listScoreboardsByLeagueDescWonAndAverage($league->id);
        $predictions = $this->championshipPredictionService->getPredictions($league, $scoreboards);

        return ScoreboardResource::collection($scoreboards)->additional(['predictions' => $predictions]);
    }
}
