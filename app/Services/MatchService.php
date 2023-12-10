<?php

namespace App\Services;

class MatchService
{
    public function matchTeams($teams)
    {
        $weeks = count($teams) - 1;
        $matches = [];

        for ($week = 1; $week <= $weeks; $week++) {
            $teamsPlayed = [];

            foreach ($teams as $key1 => $team1) {
                foreach ($teams as $key2 => $team2) {
                    if (
                        $key1 !== $key2 &&
                        !in_array($key1, $teamsPlayed) &&
                        !in_array($key2, $teamsPlayed) &&
                        !$this->matchedInPreviousWeeks($matches, $team1->id, $team2->id)
                    ) {
                        $teamsPlayed[] = $key1;
                        $teamsPlayed[] = $key2;

                        $matches[] = [
                            'week' => $week,
                            'home_team_id' => $team1->id,
                            'away_team_id' => $team2->id,
                        ];

                        $matches[] = [
                            'week' => $week+$weeks,
                            'home_team_id' => $team2->id,
                            'away_team_id' => $team1->id,
                        ];
                    }
                }
            }
        }

        return $matches;
    }

    private function matchedInPreviousWeeks($matches, $id1, $id2)
    {
        $filteredArray = array_filter($matches, function ($match) use ($id1, $id2) {
            return ($match['home_team_id'] === $id1 && $match['away_team_id'] === $id2) ||
                ($match['home_team_id'] === $id2 && $match['away_team_id'] === $id1);
        });

        return (bool)count($filteredArray);
    }
}
