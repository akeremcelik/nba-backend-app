<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\PlayService;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function __construct(protected PlayService $playService)
    {
        //
    }

    public function playNextWeek(League $league)
    {
        try {
            $nextWeek = $league->at_week+1;
            $this->playService->playWeek($league, $nextWeek);
        } catch (\Exception $exception) {
            echo $exception;
        }
    }
}
