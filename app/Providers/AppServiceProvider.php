<?php

namespace App\Providers;

use App\Repositories\Contracts\ScoreboardInterface;
use App\Services\Contracts\ScoreboardServiceInterface;
use App\Services\Contracts\ScoreServiceInterface;
use App\Services\Contracts\StrengthServiceInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
