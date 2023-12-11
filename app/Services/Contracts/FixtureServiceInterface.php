<?php

namespace App\Services\Contracts;

interface FixtureServiceInterface
{
    public function generate(int $league_id);
}
