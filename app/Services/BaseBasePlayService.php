<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\LeagueInterface;
use App\Services\Contracts\BasePlayServiceInterface;
use App\Services\Contracts\ScoreboardServiceInterface;
use App\Services\Contracts\ScoreServiceInterface;
use App\Services\Contracts\StrengthServiceInterface;

class BaseBasePlayService implements BasePlayServiceInterface
{
    public function __construct(
        protected League $league,
        protected FixtureInterface $fixtureRepository
    )
    {
        //
    }

    public function playWeek(int $week): void
    {
        $atWeek = $this->league->at_week;
        $finalWeek = $this->league->final_week;

        if ($atWeek >= $finalWeek) {
            throw new \Exception('The league has ended');
        }

        if ($week <= $atWeek) {
            throw new \Exception('The week already has been played');
        }

        $fixtures = $this->fixtureRepository->getFixturesByLeagueAndWeek($this->league->id, $week);
        foreach ($fixtures as $fixture) {
            $this->playFixture($fixture);
        }

        app(LeagueInterface::class)->updateLeague($this->league->id, [
            'at_week' => $week
        ]);
    }

    public function playFixture(Fixture $fixture): void
    {
        $strengthService = app(StrengthServiceInterface::class);

        $homeTeamTotalStrength = $strengthService->calculateHomeTeamStrength($fixture->homeTeam);
        $awayTeamTotalStrength = $strengthService->calculateAwayTeamStrength($fixture->awayTeam);

        $scores = app(ScoreServiceInterface::class)->determineTeamScores($homeTeamTotalStrength, $awayTeamTotalStrength);

        $data = [
            'is_played' => true,
            'home_team_score' => $scores['home_team_score'],
            'away_team_score' => $scores['away_team_score']
        ];

        $this->fixtureRepository->updateFixture($fixture->id, $data);

        $scoreboardService = app(ScoreboardServiceInterface::class);

        $scoreboardService->updateHomeTeamScoreboard($fixture->league_id, $fixture->home_team_id, $scores);
        $scoreboardService->updateAwayTeamScoreboard($fixture->league_id, $fixture->away_team_id, $scores);
    }
}
