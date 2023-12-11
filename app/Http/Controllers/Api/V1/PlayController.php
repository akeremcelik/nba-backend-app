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
        $this->playService->play();

        return response()->json([
            'status' => true
        ]);
    }

    public function playAllWeeks(League $league): \Illuminate\Http\JsonResponse
    {
        $this->playService->play();

        return response()->json([
            'status' => true
        ]);
    }
}
