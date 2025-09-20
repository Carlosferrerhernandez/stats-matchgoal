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
        Schema::table('predictions', function (Blueprint $table) {
            $table->decimal('bet_amount', 12, 2)->nullable()->after('suggested_stake'); // Monto apostado en COP
            $table->decimal('net_profit', 12, 2)->nullable()->after('profit_loss'); // Ganancia neta (sin stake)
            $table->decimal('roi_percentage', 8, 2)->nullable()->after('net_profit'); // ROI en porcentaje
            $table->timestamp('placed_at')->nullable()->after('status'); // Cuándo se colocó la apuesta
            $table->string('bookmaker')->nullable()->after('placed_at'); // Casa de apuesta usada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropColumn(['bet_amount', 'net_profit', 'roi_percentage', 'placed_at', 'bookmaker']);
        });
    }
};
