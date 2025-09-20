<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laLiga = \App\Models\League::where('name', 'LaLiga')->first();
        $teams = \App\Models\Team::where('league_id', $laLiga->id)->get();

        // Estadísticas realistas para algunos equipos clave
        $teamStats = [
            'Real Betis' => [
                'matches_played' => 10,
                'wins' => 6,
                'draws' => 2,
                'losses' => 2,
                'goals_for' => 18,
                'goals_against' => 12,
                'home_wins' => 4,
                'home_draws' => 1,
                'home_losses' => 0,
                'away_wins' => 2,
                'away_draws' => 1,
                'away_losses' => 2,

                // Rachas específicas (como en tu ejemplo: Betis favorito con buenas rachas)
                'streak_first_to_score_success' => 5,
                'streak_first_to_score_total' => 5, // (5/5) - Excelente racha
                'streak_first_half_winner_success' => 4,
                'streak_first_half_winner_total' => 5, // (4/5) - Muy buena
                'streak_both_teams_score_success' => 6,
                'streak_both_teams_score_total' => 7, // (6/7) - Muy buena
                'streak_over_25_goals_success' => 4,
                'streak_over_25_goals_total' => 5, // (4/5) - Buena
                'streak_no_defeats_success' => 3,
                'streak_no_defeats_total' => 3, // Sin derrotas en últimos 3
            ],
            'Real Sociedad' => [
                'matches_played' => 10,
                'wins' => 3,
                'draws' => 4,
                'losses' => 3,
                'goals_for' => 12,
                'goals_against' => 14,
                'home_wins' => 2,
                'home_draws' => 2,
                'home_losses' => 1,
                'away_wins' => 1,
                'away_draws' => 2,
                'away_losses' => 2,

                // Rachas más débiles (rival del ejemplo)
                'streak_first_to_score_success' => 2,
                'streak_first_to_score_total' => 5, // (2/5) - Débil
                'streak_first_to_concede_success' => 4,
                'streak_first_to_concede_total' => 5, // (4/5) - Problema defensivo
                'streak_first_half_winner_success' => 2,
                'streak_first_half_winner_total' => 5, // (2/5) - Débil en primeros tiempos
                'streak_both_teams_score_success' => 3,
                'streak_both_teams_score_total' => 7, // (3/7) - Regular
                'streak_no_wins_success' => 3,
                'streak_no_wins_total' => 3, // Sin ganar en últimos 3
            ],
            'Real Madrid' => [
                'matches_played' => 10,
                'wins' => 8,
                'draws' => 1,
                'losses' => 1,
                'goals_for' => 25,
                'goals_against' => 8,
                'home_wins' => 4,
                'home_draws' => 1,
                'home_losses' => 0,
                'away_wins' => 4,
                'away_draws' => 0,
                'away_losses' => 1,

                // Rachas excelentes (equipo top)
                'streak_first_to_score_success' => 9,
                'streak_first_to_score_total' => 10, // (9/10)
                'streak_first_half_winner_success' => 8,
                'streak_first_half_winner_total' => 10, // (8/10)
                'streak_victories_success' => 5,
                'streak_victories_total' => 5, // Racha de 5 victorias consecutivas
                'streak_over_25_goals_success' => 7,
                'streak_over_25_goals_total' => 8, // (7/8)
            ]
        ];

        foreach ($teams as $team) {
            $stats = $teamStats[$team->name] ?? $this->getRandomStats();

            \App\Models\TeamStat::updateOrCreate(
                [
                    'team_id' => $team->id,
                    'league_id' => $laLiga->id,
                    'season' => '2024-25'
                ],
                array_merge($stats, [
                    'team_id' => $team->id,
                    'league_id' => $laLiga->id,
                    'season' => '2024-25',
                    'last_updated' => now()
                ])
            );
        }

        $this->command->info('Team stats seeded successfully!');
    }

    private function getRandomStats()
    {
        return [
            'matches_played' => rand(8, 12),
            'wins' => rand(2, 7),
            'draws' => rand(1, 4),
            'losses' => rand(1, 5),
            'goals_for' => rand(8, 20),
            'goals_against' => rand(8, 18),
            'home_wins' => rand(1, 4),
            'home_draws' => rand(0, 2),
            'home_losses' => rand(0, 2),
            'away_wins' => rand(1, 3),
            'away_draws' => rand(0, 2),
            'away_losses' => rand(1, 3),

            // Rachas aleatorias pero realistas
            'streak_first_to_score_success' => rand(2, 5),
            'streak_first_to_score_total' => 5,
            'streak_first_half_winner_success' => rand(2, 5),
            'streak_first_half_winner_total' => 5,
            'streak_both_teams_score_success' => rand(4, 7),
            'streak_both_teams_score_total' => 7,
            'streak_over_25_goals_success' => rand(3, 5),
            'streak_over_25_goals_total' => 5,
        ];
    }
}
