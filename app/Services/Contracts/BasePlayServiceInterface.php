<?php

namespace App\Services\Contracts;

use App\Models\Fixture;
use App\Models\League;

interface BasePlayServiceInterface
{
    public function playWeek(int $week);
    public function playFixture(Fixture $fixture);
}
