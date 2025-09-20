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
        Schema::table('user_settings', function (Blueprint $table) {
            // Reemplazar el sistema de porcentajes por stake base configurable
            $table->decimal('stake_base_amount', 10, 2)->default(5000.00)->after('user_id'); // Valor base por unidad de stake en COP
            $table->integer('max_stake_level')->default(4)->after('stake_base_amount'); // Máximo nivel de stake (1-4)

            // Remover campos antiguos de porcentajes
            $table->dropColumn(['min_bet_percentage', 'max_bet_percentage']);

            // Configuraciones de gestión de capital
            $table->decimal('target_bankroll_growth', 10, 2)->nullable()->after('max_stake_level'); // Meta de crecimiento para ajustar stakes
            $table->boolean('auto_adjust_stakes')->default(false)->after('target_bankroll_growth'); // Auto-ajustar stakes cuando se alcance la meta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_settings', function (Blueprint $table) {
            // Restaurar campos antiguos
            $table->decimal('min_bet_percentage', 5, 2)->default(1.00);
            $table->decimal('max_bet_percentage', 5, 2)->default(4.00);

            // Remover nuevos campos
            $table->dropColumn([
                'stake_base_amount',
                'max_stake_level',
                'target_bankroll_growth',
                'auto_adjust_stakes'
            ]);
        });
    }
};
