<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->string('season')->default('2024-25');

            // Rachas actuales
            $table->integer('current_win_streak')->default(0);
            $table->integer('current_draw_streak')->default(0);
            $table->integer('current_loss_streak')->default(0);
            $table->integer('current_unbeaten_streak')->default(0);
            $table->integer('current_winless_streak')->default(0);

            // Estadísticas generales
            $table->integer('matches_played')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('draws')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);

            // Rachas específicas que analizas (formato: éxitos/total)
            $table->integer('streak_no_defeats_success')->default(0); // Sin derrotas (>= 3)
            $table->integer('streak_no_defeats_total')->default(0);
            $table->integer('streak_victories_success')->default(0); // Victorias consecutivas (>= 3)
            $table->integer('streak_victories_total')->default(0);

            // Rachas de goles
            $table->integer('streak_over_25_goals_success')->default(0); // Más de 2.5 goles
            $table->integer('streak_over_25_goals_total')->default(0);
            $table->integer('streak_under_25_goals_success')->default(0); // Menos de 2.5 goles
            $table->integer('streak_under_25_goals_total')->default(0);

            // Rachas de tarjetas y corners
            $table->integer('streak_under_45_cards_success')->default(0); // Menos de 4.5 tarjetas
            $table->integer('streak_under_45_cards_total')->default(0);
            $table->integer('streak_under_105_corners_success')->default(0); // Menos de 10.5 corners
            $table->integer('streak_under_105_corners_total')->default(0);

            // Rachas negativas
            $table->integer('streak_no_wins_success')->default(0); // Sin victorias (>= 3)
            $table->integer('streak_no_wins_total')->default(0);
            $table->integer('streak_no_clean_sheets_success')->default(0); // Ninguna portería a cero (>= 4)
            $table->integer('streak_no_clean_sheets_total')->default(0);

            // Rachas de goles marcados/encajados
            $table->integer('streak_first_to_concede_success')->default(0); // Primero en encajar
            $table->integer('streak_first_to_concede_total')->default(0);
            $table->integer('streak_first_to_score_success')->default(0); // Primero en marcar
            $table->integer('streak_first_to_score_total')->default(0);

            // Rachas de primer período
            $table->integer('streak_first_half_winner_success')->default(0); // Ganador primer período
            $table->integer('streak_first_half_winner_total')->default(0);
            $table->integer('streak_first_half_loser_success')->default(0); // Perdedor primer período
            $table->integer('streak_first_half_loser_total')->default(0);

            // Rachas BTTS
            $table->integer('streak_both_teams_score_success')->default(0); // Ambos equipos marcan
            $table->integer('streak_both_teams_score_total')->default(0);

            // Local vs Visitante
            $table->integer('home_wins')->default(0);
            $table->integer('home_draws')->default(0);
            $table->integer('home_losses')->default(0);
            $table->integer('away_wins')->default(0);
            $table->integer('away_draws')->default(0);
            $table->integer('away_losses')->default(0);

            $table->timestamp('last_updated')->nullable();
            $table->timestamps();

            // Índices
            $table->unique(['team_id', 'league_id', 'season']);
            $table->index(['league_id', 'season']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};
