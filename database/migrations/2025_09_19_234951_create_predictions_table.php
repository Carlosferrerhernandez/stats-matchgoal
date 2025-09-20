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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('football_matches')->onDelete('cascade');
            $table->foreignId('market_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('prediction'); // El pronóstico específico (ej: "Home Win", "Both Teams Score: Yes")
            $table->decimal('confidence_score', 5, 2); // Puntuación de confianza del algoritmo (0-100)
            $table->integer('suggested_stake'); // Stake sugerido (1-10)
            $table->decimal('expected_odds', 8, 2)->nullable(); // Cuotas esperadas
            $table->text('reasoning')->nullable(); // Razonamiento del algoritmo

            $table->string('status')->default('pending'); // pending, placed, won, lost, void
            $table->boolean('result')->nullable(); // Resultado final
            $table->decimal('actual_odds', 8, 2)->nullable(); // Cuotas reales obtenidas
            $table->decimal('profit_loss', 10, 2)->nullable(); // Ganancia/pérdida real

            $table->timestamps();

            // Índices
            $table->index(['match_id', 'market_id']);
            $table->index(['user_id', 'status']);
            $table->index('confidence_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
