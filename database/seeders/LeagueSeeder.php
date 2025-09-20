<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = [
            [
                'name' => 'LaLiga',
                'country' => 'España',
                'season' => '2024-25'
            ],
            [
                'name' => 'Premier League',
                'country' => 'Inglaterra',
                'season' => '2024-25'
            ],
            [
                'name' => 'Serie A',
                'country' => 'Italia',
                'season' => '2024-25'
            ],
            [
                'name' => 'Bundesliga',
                'country' => 'Alemania',
                'season' => '2024-25'
            ],
            [
                'name' => 'Ligue 1',
                'country' => 'Francia',
                'season' => '2024-25'
            ]
        ];

        foreach ($leagues as $league) {
            \App\Models\League::updateOrCreate(
                ['name' => $league['name'], 'season' => $league['season']],
                $league
            );
        }

        $this->command->info('Leagues seeded successfully!');
    }
}
