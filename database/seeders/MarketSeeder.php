<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Market;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $markets = [
            [
                'name' => 'Ganador del Primer Período',
                'key' => Market::FIRST_HALF_WINNER,
                'description' => 'Equipo que gana el primer tiempo (45 minutos)',
                'is_active' => true
            ],
            [
                'name' => 'Ganador del Partido',
                'key' => Market::MATCH_WINNER,
                'description' => 'Equipo que gana el partido completo (90 minutos)',
                'is_active' => true
            ],
            [
                'name' => 'Primero en Marcar',
                'key' => Market::FIRST_GOAL,
                'description' => 'Equipo que marca el primer gol del partido',
                'is_active' => true
            ],
            [
                'name' => 'Ambos Equipos Marcan',
                'key' => Market::BOTH_TEAMS_SCORE,
                'description' => 'Si ambos equipos marcan al menos un gol',
                'is_active' => true
            ]
        ];

        foreach ($markets as $market) {
            Market::updateOrCreate(
                ['key' => $market['key']],
                $market
            );
        }

        $this->command->info('Markets seeded successfully!');
    }
}
