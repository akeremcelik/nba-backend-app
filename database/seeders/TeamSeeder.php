<?php

namespace Database\Seeders;

use App\Repositories\Contracts\TeamInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(TeamInterface $teamRepository): void
    {
        $teams = [
            'Los Angeles Lakers',
            'Boston Celtics',
            'Chicago Bulls',
            'Miami Heat',
        ];

        foreach ($teams as $team) {
            $data = [
                'name' => $team,
            ];

            $teamRepository->createTeam($data);
        }
    }
}
