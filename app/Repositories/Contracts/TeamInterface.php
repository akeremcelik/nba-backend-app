<?php

namespace App\Repositories\Contracts;

interface TeamInterface
{
    public function createTeam(array $data);
    public function getTeams();
}
