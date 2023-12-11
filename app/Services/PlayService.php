<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Services\Contracts\ScoreServiceInterface;
use App\Services\Contracts\StrengthServiceInterface;

class PlayService
{
    public function __construct(
        protected LeagueInterface     $leagueRepository,
        protected FixtureInterface    $fixtureRepository,
        protected ScoreboardService   $scoreboardService,
    )
    {
        //
    }

    public function playWeek(League $league, int $week): void
    {
        $atWeek = $league->at_week;
        $finalWeek = $league->final_week;

        if ($atWeek >= $finalWeek) {
            throw new \Exception('The league has ended');
        }

        if ($week <= $atWeek) {
            throw new \Exception('The week already has been played');
        }

        $fixtures = $this->fixtureRepository->getFixturesByLeagueAndWeek($league->id, $week);
        foreach ($fixtures as $fixture) {
            $this->playFixture($fixture);
        }

        $this->leagueRepository->updateLeague($league->id, [
            'at_week' => $week
        ]);
    }

    public function playAllWeeks(League $league)
    {
        $atWeek = $league->at_week;
        $finalWeek = $league->final_week;

        for ($i = $atWeek + 1; $i <= $finalWeek; $i++) {
            $this->playWeek($league, $i);
        }
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

        $this->scoreboardService->updateHomeTeamScoreboard($fixture->league_id, $fixture->home_team_id, $scores);
        $this->scoreboardService->updateAwayTeamScoreboard($fixture->league_id, $fixture->away_team_id, $scores);
    }
}
