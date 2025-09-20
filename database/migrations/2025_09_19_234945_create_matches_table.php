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
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->datetime('match_date');
            $table->string('status')->default('scheduled'); // scheduled, live, finished, postponed

            // Porcentajes de predicción
            $table->decimal('home_win_percent', 5, 2)->nullable();
            $table->decimal('draw_percent', 5, 2)->nullable();
            $table->decimal('away_win_percent', 5, 2)->nullable();

            // Resultados (si el partido ya terminó)
            $table->integer('home_goals')->nullable();
            $table->integer('away_goals')->nullable();
            $table->integer('home_goals_first_half')->nullable();
            $table->integer('away_goals_first_half')->nullable();

            // Metadatos para scraping
            $table->string('external_id')->nullable(); // ID del sitio de origen
            $table->timestamp('last_updated')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['league_id', 'match_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};
