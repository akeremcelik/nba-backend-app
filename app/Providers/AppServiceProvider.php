<?php

namespace App\Providers;

use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\LeagueInterface;
use App\Repositories\Contracts\ScoreboardInterface;
use App\Services\Contracts\FixtureServiceInterface;
use App\Services\Contracts\LeagueServiceInterface;
use App\Services\Contracts\MatchServiceInterface;
use App\Services\Contracts\PlayServiceInterface;
use App\Services\Contracts\ScoreboardServiceInterface;
use App\Services\Contracts\ScoreServiceInterface;
use App\Services\Contracts\StrengthServiceInterface;
use App\Services\FixtureService;
use App\Services\LeagueService;
use App\Services\MatchService;
use App\Services\PlayService;
use App\Services\ScoreboardService;
use App\Services\ScoreService;
use App\Services\StrengthService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StrengthServiceInterface::class, StrengthService::class);
        $this->app->singleton(ScoreServiceInterface::class, ScoreService::class);

        $this->app->singleton(ScoreboardServiceInterface::class, function ($app) {
            $scoreboardRepository = $app->make(ScoreboardInterface::class);
            return new ScoreboardService($scoreboardRepository);
        });

        $this->app->singleton(PlayServiceInterface::class, function ($app) {
            $fixtureRepository = $app->make(FixtureInterface::class);
            return new PlayService($fixtureRepository);
        });

        $this->app->singleton(MatchServiceInterface::class, MatchService::class);

        $this->app->singleton(LeagueServiceInterface::class, function ($app) {
            $leagueRepository = $app->make(LeagueInterface::class);
            return new LeagueService($leagueRepository);
        });

        $this->app->singleton(FixtureServiceInterface::class, function ($app) {
            $fixtureRepository = $app->make(FixtureInterface::class);
            return new FixtureService($fixtureRepository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
