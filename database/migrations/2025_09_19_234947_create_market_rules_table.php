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
        Schema::create('market_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')->constrained()->onDelete('cascade');
            $table->string('rule_name'); // Nombre de la regla
            $table->string('condition_type'); // win_percent_difference, win_streak, etc.
            $table->string('operator'); // >=, <=, =, >, <
            $table->decimal('value', 8, 2); // Valor de la condición
            $table->decimal('weight', 5, 2)->default(1.0); // Peso de la regla en el algoritmo
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['market_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_rules');
    }
};
