<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function updateFixture(int $id, array $data);
    public function getGroupedFixturesWithRelationsByLeague(int $league_id);
    public function getFixturesByLeagueAndWeek(int $league_id, int $week);
    public function getGroupedFixturesWithRelationsByLeagueAndWeek(int $league_id, int $week);
    public function getPlayedFixturesWithTeams(int $league_id);
}
