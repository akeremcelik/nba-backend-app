<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Services\FixtureService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(protected FixtureService $fixtureService)
    {
        //
    }

    public function generateFixtures(): void
    {
        $this->fixtureService->clear();
        $this->fixtureService->generate();
    }

    public function listFixtures()
    {
        $fixtures = $this->fixtureService->list();

        return FixtureResource::collection($fixtures);
    }
}
