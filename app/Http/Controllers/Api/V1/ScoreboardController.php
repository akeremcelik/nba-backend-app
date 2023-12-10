<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
use App\Models\League;
use App\Repositories\Contracts\ScoreboardInterface;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function __construct(
        protected ScoreboardInterface $scoreboardRepository,
    )
    {
        //
    }

    public function listScoreboard(League $league): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $scoreboards = $this->scoreboardRepository->listScoreboardsByLeagueDescWonAndAverage($league->id);

        return ScoreboardResource::collection($scoreboards);
    }
}
