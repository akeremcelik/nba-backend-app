<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\FixtureController;
use App\Http\Controllers\Api\V1\PlayController;
use App\Http\Controllers\Api\V1\ScoreboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('teams', [TeamController::class, 'getTeams']);

    Route::post('generate-fixtures', [FixtureController::class, 'generateFixtures']);
    Route::prefix('leagues/{league}')->group(function () {
        Route::get('list-fixtures', [FixtureController::class, 'listFixtures']);
        Route::get('list-week-fixtures', [FixtureController::class, 'listWeekFixtures']);
        Route::get('list-scoreboard', [ScoreboardController::class, 'listScoreboard']);

        Route::post('play-next-week', [PlayController::class, 'playNextWeek']);
        Route::post('play-all-weeks', [PlayController::class, 'playAllWeeks']);
    });
});
