<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\League;
use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\ScoreboardInterface;

class PlayService
{
    public function __construct(
        protected LeagueInterface     $leagueRepository,
        protected FixtureInterface    $fixtureRepository,
        protected ScoreboardInterface $scoreboardRepository,
        protected StrengthService     $strengthCalculationService,
        protected ScoreService        $scoreCalculationService,
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
        $homeTeamTotalStrength = $this->strengthCalculationService->calculateHomeTeamStrength($fixture->homeTeam);
        $awayTeamTotalStrength = $this->strengthCalculationService->calculateAwayTeamStrength($fixture->awayTeam);

        $scores = $this->scoreCalculationService->determineTeamScores($homeTeamTotalStrength, $awayTeamTotalStrength);

        $data = [
            'is_played' => true,
            'home_team_score' => $scores['home_team_score'],
            'away_team_score' => $scores['away_team_score']
        ];

        $this->fixtureRepository->updateFixture($fixture->id, $data);

        $this->updateHomeTeamScoreboard($fixture, $scores);
        $this->updateAwayTeamScoreboard($fixture, $scores);
    }

    public function updateHomeTeamScoreboard(Fixture $fixture, array $scores): void
    {
        $scoreboard = $this->scoreboardRepository->findScoreboardByLeagueAndTeam($fixture->league_id, $fixture->home_team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['home_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['away_team_score'],
            'average' => $scoreboard->average + ($scores['home_team_score'] - $scores['away_team_score']),
        ];

        if ($scores['home_team_score'] > $scores['away_team_score']) {
            $data['won'] = $scoreboard->won + 1;
        } else {
            $data['lost'] = $scoreboard->lost + 1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }

    public function updateAwayTeamScoreboard(Fixture $fixture, array $scores): void
    {
        $scoreboard = $this->scoreboardRepository->findScoreboardByLeagueAndTeam($fixture->league_id, $fixture->away_team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['away_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['home_team_score'],
            'average' => $scoreboard->average + ($scores['away_team_score'] - $scores['home_team_score']),
        ];

        if ($scores['away_team_score'] > $scores['home_team_score']) {
            $data['won'] = $scoreboard->won + 1;
        } else {
            $data['lost'] = $scoreboard->lost + 1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }
}
