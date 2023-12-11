<?php

namespace App\Repositories\Contracts;

interface ScoreboardInterface
{
    public function createScoreboard(array $data);
    public function updateScoreboard(int $id, array $data);
}
