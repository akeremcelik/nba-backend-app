<?php

namespace App\Services;

use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Services\Contracts\FixtureServiceInterface;
use App\Services\Contracts\MatchServiceInterface;
use Illuminate\Support\Facades\App;

class FixtureService implements FixtureServiceInterface
{
    public function __construct(
        protected FixtureInterface $fixtureRepository,
    )
    {
        //
    }

    public function generate(int $league_id): void
    {
        $teams = App::make(TeamInterface::class)->getTeams();
        $teams = $teams->shuffle();

        foreach ($teams as $team) {
            $data = [
                'league_id' => $league_id,
                'team_id' => $team->id,
            ];

            app(ScoreboardInterface::class)->createScoreboard($data);
        }

        $fixtures = app(MatchServiceInterface::class)->matchTeams($teams->toArray());
        foreach ($fixtures as $fixture) {
            $data = [
                'league_id' => $league_id,
                ...$fixture
            ];

            $this->fixtureRepository->createFixture($data);
        }
    }
}
