<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function getFixturesWithRelationsByLeague(int $league_id);
    public function getFixturesByLeagueAndWeek(int $league_id, int $week);
    public function updateFixture(int $id, array $data);
}
