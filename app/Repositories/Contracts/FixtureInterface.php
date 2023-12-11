<?php

namespace App\Repositories\Contracts;

interface FixtureInterface
{
    public function createFixture(array $data);
    public function updateFixture(int $id, array $data);
}
