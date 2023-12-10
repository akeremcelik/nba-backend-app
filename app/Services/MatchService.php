<?php

namespace App\Services;

class MatchService
{
    public function matchTeams(array $teams): array
    {
        $numTeams = count($teams);

        $matchesPerWeek = $numTeams / 2;
        $totalWeeks = $numTeams - 1;

        $matches = [];

        for ($week = 1; $week <= $totalWeeks; $week++) {
            for ($i = 0; $i < $matchesPerWeek; $i++) {
                $team1 = $teams[$i];
                $team2 = $teams[$numTeams - 1 - $i];

                $matches[] = [
                    'week' => $week,
                    'home_team_id' => $team1['id'],
                    'away_team_id' => $team2['id']
                ];

                $matches[] = [
                    'week' => $week+$totalWeeks,
                    'home_team_id' => $team2['id'],
                    'away_team_id' => $team1['id']
                ];
            }

            $teams = array_merge(array($teams[0]), array_slice($teams, 2, $numTeams - 2), array($teams[1]));
        }

        return $matches;
    }
}
