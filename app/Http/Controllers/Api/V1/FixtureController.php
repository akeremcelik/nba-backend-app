<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Http\Resources\Api\V1\LeagueResource;
use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
use App\Services\Contracts\FixtureServiceInterface;
use App\Services\Contracts\LeagueServiceInterface;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(
        protected FixtureServiceInterface $fixtureService,
    )
    {
        //
    }

    public function generateFixtures(LeagueServiceInterface $leagueService)
    {
        $league = $leagueService->create();
        $this->fixtureService->generate($league->id);

        return LeagueResource::make($league);
    }

    public function listFixtures(League $league, FixtureInterface $fixtureRepository)
    {
        $fixtures = $fixtureRepository->getFixturesByLeague($league->id);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }

    public function listWeekFixtures(League $league, FixtureInterface $fixtureRepository)
    {
        $atWeek = $league->at_week;
        $week = $atWeek + 1;

        $fixtures = $fixtureRepository->getFixturesByLeagueAndWeek($league->id, $week);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }

    public function listPlayedFixtures(League $league, FixtureInterface $fixtureRepository)
    {
        $fixtures = $fixtureRepository->getPlayedFixturesByLeague($league->id);

        return FixtureResource::collection($fixtures)
            ->groupBy('week');
    }
}
