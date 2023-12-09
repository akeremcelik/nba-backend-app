<?php

namespace App\Repositories\Contracts;

interface ScoreboardInterface
{
    public function updateOrCreateScoreboard($data1, $data2);
}
