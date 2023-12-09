<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Team;
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

    const HOME_CONSTANT = 1.5;
    const AWAY_CONSTANT = 1.0;
    const RANDOM_STRENGTH_CONSTANT = 50;

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

            $this->leagueRepository->updateLeague($league_id, [
                'at_week' => $atWeek+1
            ]);
        }
    }

    public function playFixture(Fixture $fixture)
    {
        $scores = $this->determineTeamScores($fixture->homeTeam, $fixture->awayTeam);

        $data = [
            'is_played' => true,
            'home_team_score' => $scores['home_team_score'],
            'away_team_score' => $scores['away_team_score']
        ];

        $this->fixtureRepository->updateFixture($fixture->id, $data);

        $this->updateHomeTeamScoreboard($fixture, $scores);
        $this->updateAwayTeamScoreboard($fixture, $scores);
    }

    public function determineTeamScores(Team $homeTeam, Team $awayTeam)
    {
        $homeTeamTotalStrength = $this->calculateHomeTeamStrength($homeTeam);
        $awayTeamTotalStrength = $this->calculateAwayTeamStrength($awayTeam);

        $randomScore = random_int(80, 100);
        $homeTeamScore = $randomScore;
        $awayTeamScore = $randomScore;

        if ($homeTeamTotalStrength > $awayTeamTotalStrength) {
            $homeTeamScore = $awayTeamScore + random_int(0, ($homeTeamTotalStrength-$awayTeamTotalStrength));
        } elseif ($homeTeamTotalStrength < $awayTeamTotalStrength) {
            $awayTeamScore = $homeTeamScore + random_int(0, ($awayTeamTotalStrength-$homeTeamTotalStrength));
        } else {
            // avoid draw
            random_int(0, 1) === 0 ? $homeTeamScore += 1 : $awayTeamScore += 1;
        }

        return [
            'home_team_score' => $homeTeamScore,
            'away_team_score' => $awayTeamScore
        ];
    }

    public function calculateHomeTeamStrength(Team $homeTeam)
    {
        $strength = [
            'team' => $homeTeam->team_strength,
            'location' => self::HOME_CONSTANT * $homeTeam->home_strength,
            'random' => random_int(0, self::RANDOM_STRENGTH_CONSTANT)
        ];

        return array_sum($strength);
    }

    public function calculateAwayTeamStrength(Team $awayTeam)
    {
        $strength = [
            'team' => $awayTeam->team_strength,
            'location' => self::AWAY_CONSTANT * $awayTeam->away_strength,
            'random' => random_int(0, self::RANDOM_STRENGTH_CONSTANT)
        ];

        return array_sum($strength);
    }

    public function updateHomeTeamScoreboard(Fixture $fixture, array $scores)
    {
        $scoreboard = $this->scoreboardRepository->findScoreboardByLeagueAndTeam($fixture->league_id, $fixture->home_team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['home_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['away_team_score']
        ];

        if ($scores['home_team_score'] > $scores['away_team_score']) {
            $data['won'] = $scoreboard->won+1;
        } else {
            $data['lost'] = $scoreboard->lost+1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }

    public function updateAwayTeamScoreboard(Fixture $fixture, array $scores)
    {
        $scoreboard = $this->scoreboardRepository->findScoreboardByLeagueAndTeam($fixture->league_id, $fixture->away_team_id);

        $data = [
            'played' => $scoreboard->played + 1,
            'scores_out' => $scoreboard->scores_out + $scores['away_team_score'],
            'scores_in' => $scoreboard->scores_in + $scores['home_team_score']
        ];

        if ($scores['away_team_score'] > $scores['home_team_score']) {
            $data['won'] = $scoreboard->won+1;
        } else {
            $data['lost'] = $scoreboard->lost+1;
        }

        $this->scoreboardRepository->updateScoreboard($scoreboard->id, $data);
    }
}
