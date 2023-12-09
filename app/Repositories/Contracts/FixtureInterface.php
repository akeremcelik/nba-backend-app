<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function listFixturesByLeagueId(int $league_id);
}
