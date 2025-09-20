<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FootballMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laLiga = \App\Models\League::where('name', 'LaLiga')->first();
        $betis = \App\Models\Team::where('name', 'Real Betis')->first();
        $realSociedad = \App\Models\Team::where('name', 'Real Sociedad')->first();
        $madrid = \App\Models\Team::where('name', 'Real Madrid')->first();
        $barcelona = \App\Models\Team::where('name', 'FC Barcelona')->first();

        $matches = [
            // Tu ejemplo: Betis (49%) vs Real Sociedad (25%), Empate (25%)
            [
                'league_id' => $laLiga->id,
                'home_team_id' => $betis->id,
                'away_team_id' => $realSociedad->id,
                'match_date' => now()->addDays(2),
                'status' => 'scheduled',
                'home_win_percent' => 49.00,
                'draw_percent' => 25.00,
                'away_win_percent' => 25.00,
                'external_id' => 'BETIS_RSOC_20240921'
            ],
            // Partido adicional para más pruebas
            [
                'league_id' => $laLiga->id,
                'home_team_id' => $madrid->id,
                'away_team_id' => $barcelona->id,
                'match_date' => now()->addDays(5),
                'status' => 'scheduled',
                'home_win_percent' => 45.00,
                'draw_percent' => 28.00,
                'away_win_percent' => 27.00,
                'external_id' => 'MADRID_BARCA_20240924'
            ],
            // Partido ya finalizado para validar resultados
            [
                'league_id' => $laLiga->id,
                'home_team_id' => $madrid->id,
                'away_team_id' => \App\Models\Team::where('name', 'Sevilla')->first()->id,
                'match_date' => now()->subDays(3),
                'status' => 'finished',
                'home_win_percent' => 65.00,
                'draw_percent' => 20.00,
                'away_win_percent' => 15.00,
                'home_goals' => 3,
                'away_goals' => 1,
                'home_goals_first_half' => 2,
                'away_goals_first_half' => 0,
                'external_id' => 'MADRID_SEV_20240916'
            ]
        ];

        foreach ($matches as $match) {
            \App\Models\FootballMatch::updateOrCreate(
                ['external_id' => $match['external_id']],
                $match
            );
        }

        $this->command->info('Football matches seeded successfully!');
    }
}
