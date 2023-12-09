<?php

namespace App\Services;

use App\Repositories\Contracts\LeagueInterface;

class PlayService
{
    public function __construct(
        protected LeagueInterface $leagueRepository,
    )
    {
        //
    }

    public function playWeek(int $league_id, int $week)
    {
        $league = $this->leagueRepository->findOrFailLeague($league_id);
    }
}
