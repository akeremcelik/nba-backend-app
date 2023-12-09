<?php

namespace App\Services;

use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\TeamInterface;
use Illuminate\Support\Facades\App;

class FixtureService
{
    public function __construct(
        protected MatchService     $matchService,
        protected FixtureInterface $fixtureRepository,
    )
    {
        //
    }

    public function generate(League $league)
    {
        $teams = App::make(TeamInterface::class)->getTeams();
        $fixtures = $this->matchService->matchTeams($teams);

        foreach ($fixtures as $fixture) {
            $data = [
                'league_id' => $league->id,
                ...$fixture
            ];

            $this->fixtureRepository->createFixture($data);
        }

        return $league;
    }

    public function list(int $league_id)
    {
        return $this->fixtureRepository->getFixturesWithRelationsByLeague($league_id);
    }
}
