<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Http\Resources\Api\V1\LeagueResource;
use App\Models\League;
use App\Services\FixtureService;
use App\Services\LeagueService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(
        protected FixtureService $fixtureService,
        protected LeagueService  $leagueService,
    )
    {
        //
    }

    public function generateFixtures()
    {
        $league = $this->leagueService->create();
        $this->fixtureService->generate($league);

        return LeagueResource::make($league);
    }

    public function listFixtures(int $league_id)
    {
        $fixtures = $this->fixtureService->list($league_id);

        return FixtureResource::collection($fixtures);
    }
}
