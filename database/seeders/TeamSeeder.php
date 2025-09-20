<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laLigaId = \App\Models\League::where('name', 'LaLiga')->first()->id;

        $teams = [
            ['name' => 'Real Madrid', 'league_id' => $laLigaId],
            ['name' => 'FC Barcelona', 'league_id' => $laLigaId],
            ['name' => 'Atlético Madrid', 'league_id' => $laLigaId],
            ['name' => 'Real Sociedad', 'league_id' => $laLigaId],
            ['name' => 'Real Betis', 'league_id' => $laLigaId],
            ['name' => 'Villarreal', 'league_id' => $laLigaId],
            ['name' => 'Athletic Bilbao', 'league_id' => $laLigaId],
            ['name' => 'Valencia', 'league_id' => $laLigaId],
            ['name' => 'Sevilla', 'league_id' => $laLigaId],
            ['name' => 'Real Valladolid', 'league_id' => $laLigaId],
            ['name' => 'Girona', 'league_id' => $laLigaId],
            ['name' => 'Osasuna', 'league_id' => $laLigaId],
            ['name' => 'Getafe', 'league_id' => $laLigaId],
            ['name' => 'Rayo Vallecano', 'league_id' => $laLigaId],
            ['name' => 'Celta Vigo', 'league_id' => $laLigaId],
            ['name' => 'Las Palmas', 'league_id' => $laLigaId],
            ['name' => 'Deportivo Alavés', 'league_id' => $laLigaId],
            ['name' => 'RCD Espanyol', 'league_id' => $laLigaId],
            ['name' => 'Real Mallorca', 'league_id' => $laLigaId],
            ['name' => 'CD Leganés', 'league_id' => $laLigaId]
        ];

        foreach ($teams as $team) {
            \App\Models\Team::updateOrCreate(
                ['name' => $team['name'], 'league_id' => $team['league_id']],
                $team
            );
        }

        $this->command->info('Teams seeded successfully!');
    }
}
