<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function listFixtures();
}
