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
            [
                'name' => 'Los Angeles Lakers',
                'team_strength' => 95,
                'home_strength' => 10,
                'away_strength' => 5,
            ],
            [
                'name' => 'Boston Celtics',
                'team_strength' => 80,
                'home_strength' => 15,
                'away_strength' => 5,
            ],
            [
                'name' => 'Chicago Bulls',
                'team_strength' => 65,
                'home_strength' => 16,
                'away_strength' => 3,
            ],
            [
                'name' => 'Miami Heat',
                'team_strength' => 50,
                'home_strength' => 8,
                'away_strength' => 20,
            ]
        ];

        foreach ($teams as $team) {
            $teamRepository->createTeam($team);
        }
    }
}
