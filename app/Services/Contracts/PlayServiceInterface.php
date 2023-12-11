<?php

namespace App\Services\Contracts;

use App\Models\Fixture;
use App\Models\League;

interface PlayServiceInterface
{
    public function playWeek(League $league, int $week);
    public function playAllWeeks(League $league);
    public function playFixture(Fixture $fixture);
}
