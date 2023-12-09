<?php

namespace App\Services;

use App\Repositories\Contracts\TeamInterface;
use Illuminate\Support\Facades\App;

class FixtureService
{
    public function __construct(protected MatchService $matchService)
    {
        //
    }

    public function generate()
    {
        $teams = App::make(TeamInterface::class)->getTeams();
        $matches = $this->matchService->matchTeams($teams);
    }
}
