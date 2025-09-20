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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Configuraciones de bankroll
            $table->decimal('min_bet_percentage', 5, 2)->default(1.00); // % mínimo del bank por apuesta
            $table->decimal('max_bet_percentage', 5, 2)->default(10.00); // % máximo del bank por apuesta
            $table->decimal('min_confidence_threshold', 5, 2)->default(60.00); // Confianza mínima para apostar

            // Configuraciones de stakes
            $table->json('stake_mapping')->nullable(); // Mapeo personalizado de confidence_score a stake
            $table->boolean('auto_stake_enabled')->default(true);
            $table->boolean('conservative_mode')->default(false);

            // Configuraciones de mercados
            $table->json('preferred_markets')->nullable(); // Mercados preferidos por el usuario
            $table->json('excluded_leagues')->nullable(); // Ligas excluidas

            // Configuraciones de notificaciones
            $table->boolean('email_predictions')->default(true);
            $table->boolean('high_confidence_alerts')->default(true);

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
