<?php

namespace App\Providers;

use App\Repositories\Contracts\FixtureInterface;
use App\Repositories\Contracts\TeamInterface;
use App\Repositories\Repositories\FixtureRepository;
use App\Repositories\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TeamInterface::class, TeamRepository::class);
        $this->app->bind(FixtureInterface::class, FixtureRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
