<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Http\Resources\Api\V1\LeagueResource;
use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
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
        $this->fixtureService->generate($league->id);

        return LeagueResource::make($league);
    }

    public function listFixtures(League $league, FixtureInterface $fixtureRepository)
    {
        $fixtures = $fixtureRepository->getGroupedFixturesWithRelationsByLeague($league->id);

        return $fixtures;
        // return FixtureResource::collection($fixtures);
    }
}
