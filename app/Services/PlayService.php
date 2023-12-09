<?php

namespace App\Services;

use App\Models\Fixture;
use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\ScoreboardInterface;

class PlayService
{
    public function __construct(
        protected LeagueInterface $leagueRepository,
        protected FixtureInterface $fixtureRepository,
        protected ScoreboardInterface $scoreboardRepository,
    )
    {
        //
    }

    public function playWeek(int $league_id)
    {
        $league = $this->leagueRepository->findOrFailLeague($league_id);

        $atWeek = $league->at_week;
        $finalWeek = $league->final_week;

        if ($atWeek < $finalWeek) {
            $fixtures = $this->fixtureRepository->getFixturesByLeagueAndWeek($league_id, $atWeek+1);
            foreach ($fixtures as $fixture) {
                $this->playFixture($fixture);
            }
        }
    }

    public function playFixture(Fixture $fixture)
    {
        $firstTeamScore = 100;
        $secondTeamScore = 55;

        $data = [
            'is_played' => true,
            'home_team_score' => $firstTeamScore,
            'away_team_score' => $secondTeamScore
        ];

        $this->fixtureRepository->updateFixture($fixture->id, $data);
    }
}
