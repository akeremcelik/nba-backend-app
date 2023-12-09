<?php

namespace App\Services;

use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\TeamInterface;

class LeagueService
{
    public function __construct(
        protected TeamInterface   $teamRepository,
        protected LeagueInterface $leagueRepository
    )
    {
        //
    }

    public function create()
    {
        $teams = $this->teamRepository->getTeams();
        $weeks = (count($teams)-1) * 2;

        $data = [
            'final_week' => $weeks,
        ];

        return $this->leagueRepository->createLeague($data);
    }
}
