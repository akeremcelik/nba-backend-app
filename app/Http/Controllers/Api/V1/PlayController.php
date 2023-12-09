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

    public function playNextWeek(int $league_id)
    {
        $this->playService->playWeek($league_id);
    }
}
