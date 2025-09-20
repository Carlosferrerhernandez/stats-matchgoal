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
        Schema::table('leagues', function (Blueprint $table) {
            $table->text('description')->nullable()->after('country');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->string('city')->nullable()->after('league_id');
            $table->integer('founded_year')->nullable()->after('city');
            $table->text('description')->nullable()->after('founded_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['city', 'founded_year', 'description']);
        });
    }
};
