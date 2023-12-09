<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TeamResource;
use App\Repositories\Contracts\TeamInterface;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(private TeamInterface $teamRepository)
    {
        //
    }

    public function getTeams()
    {
        $teams = $this->teamRepository->getTeams();

        return TeamResource::collection($teams);
    }
}
