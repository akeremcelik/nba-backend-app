<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Http\Resources\Api\V1\LeagueResource;
use App\Models\League;
use App\Repositories\Contracts\LeagueInterface;
use App\Services\Contracts\FixtureServiceInterface;
use App\Services\Contracts\LeagueServiceInterface;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(
        protected FixtureServiceInterface $fixtureService,
        protected LeagueInterface $leagueRepository
    )
    {
        //
    }

    public function generateFixtures(LeagueServiceInterface $leagueService): LeagueResource
    {
        $league = $leagueService->create();
        $this->fixtureService->generate($league->id);

        return LeagueResource::make($league);
    }

    public function listFixtures(League $league)
    {
        $fixtures = $this->leagueRepository->getFixtures($league->id);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }

    public function listWeekFixtures(League $league)
    {
        $fixtures = $this->leagueRepository->getWeeklyFixtures($league->id, $league->at_week + 1);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }

    public function listPlayedFixtures(League $league)
    {
        $fixtures = $this->leagueRepository->getPlayedFixtures($league->id);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }
}
