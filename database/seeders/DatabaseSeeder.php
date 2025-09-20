<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MarketSeeder::class,      // Primero los mercados
            LeagueSeeder::class,      // Luego las ligas
            TeamSeeder::class,        // Después los equipos
            ChannelSeeder::class,     // Canales de apuestas
            TeamStatSeeder::class,    // Estadísticas de equipos (rachas)
            FootballMatchSeeder::class, // Partidos con porcentajes
        ]);

        // Crear usuario de prueba con bank
        \App\Models\User::factory()->create([
            'name' => 'Carlos Pronosticador',
            'email' => 'carlos@matchgoal.com',
            'bank' => 1000.00
        ]);

        $this->command->info('🚀 MatchGoal seeded successfully!');
        $this->command->info('📊 Data ready for algorithm testing');
        $this->command->info('🎯 User: carlos@matchgoal.com (Bank: $1000)');
    }
}
