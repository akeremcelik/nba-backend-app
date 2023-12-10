<?php

namespace App\Repositories\Contracts;

interface LeagueInterface
{
    public function createLeague(array $data);
    public function updateLeague(int $league_id, array $data);
    public function findOrFailLeague(int $id);

    public function getScoreboards(int $league_id);
}
