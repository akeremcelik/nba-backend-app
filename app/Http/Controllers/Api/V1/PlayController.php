<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\Contracts\PlayServiceInterface;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function __construct(protected PlayServiceInterface $playService)
    {
        //
    }

    public function playNextWeek(League $league): \Illuminate\Http\JsonResponse
    {
        try {
            $nextWeek = $league->at_week+1;
            $this->playService->playWeek($league, $nextWeek);
        } catch (\Exception $exception) {
            echo $exception;
        }

        return response()->json([
            'status' => true
        ]);
    }

    public function playAllWeeks(League $league): \Illuminate\Http\JsonResponse
    {
        try {
            $this->playService->playAllWeeks($league);
        } catch (\Exception $exception) {
            echo $exception;
        }

        return response()->json([
            'status' => true
        ]);
    }
}
