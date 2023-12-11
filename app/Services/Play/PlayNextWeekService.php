<?php

namespace App\Services\Play;

use App\Models\League;
use App\Repositories\Repositories\FixtureRepository;
use App\Services\BaseBasePlayService;
use App\Services\Contracts\PlayServiceInterface;

class PlayNextWeekService extends BaseBasePlayService implements PlayServiceInterface
{
    public function __construct(League $league, FixtureRepository $fixtureRepository)
    {
        parent::__construct($league, $fixtureRepository);
    }

    public function play(): void
    {
        $atWeek = $this->league->at_week;
        $this->playWeek($atWeek + 1);
    }
}
