<?php

namespace App\Repositories\Contracts;

interface LeagueInterface
{
    public function createLeague(array $data);
    public function updateLeague(int $id, array $data);
    public function findOrFailLeague(int $id);
    public function getFixtures(int $id);
    public function getWeeklyFixtures(int $id, int $week);
    public function getPlayedFixtures(int $id);
    public function getScoreboards(int $id);
    public function getTeamScoreboard(int $id, int $team_id);
}
