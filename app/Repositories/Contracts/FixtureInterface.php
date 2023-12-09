<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function listFixturesByLeagueId(int $league_id);
    public function listFixturesByLeagueIdAndWeek(int $league_id, int $week);
    public function updateFixture(int $id, array $data);
}
