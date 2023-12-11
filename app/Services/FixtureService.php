<?php

namespace App\Services;

use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Services\Contracts\MatchServiceInterface;
use Illuminate\Support\Facades\App;

class FixtureService
{
    public function __construct(
        protected FixtureInterface $fixtureRepository,
        protected ScoreboardInterface $scoreboardRepository,
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

            $this->scoreboardRepository->createScoreboard($data);
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
