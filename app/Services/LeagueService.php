<?php

namespace App\Services;

use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Services\Contracts\LeagueServiceInterface;

class LeagueService implements LeagueServiceInterface
{
    public function __construct(
        protected LeagueInterface $leagueRepository
    )
    {
        //
    }

    public function create()
    {
        $teams = app(TeamInterface::class)->getTeams();
        $weeks = (count($teams)-1) * 2;

        $data = [
            'final_week' => $weeks,
        ];

        return $this->leagueRepository->createLeague($data);
    }
}
