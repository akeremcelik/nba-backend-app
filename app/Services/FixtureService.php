<?php

namespace App\Services;

use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\TeamInterface;
use Illuminate\Support\Facades\App;

class FixtureService
{
    public function __construct(protected MatchService $matchService, protected FixtureInterface $fixtureRepository)
    {
        //
    }

    public function generate()
    {
        $teams = App::make(TeamInterface::class)->getTeams();
        $fixtures = $this->matchService->matchTeams($teams);

        foreach ($fixtures as $fixture) {
            $this->fixtureRepository->createFixture($fixture);
        }
    }

    public function list()
    {
        return $this->fixtureRepository->listFixtures();
    }

    public function clear()
    {
        return $this->fixtureRepository->deleteFixtures();
    }
}
