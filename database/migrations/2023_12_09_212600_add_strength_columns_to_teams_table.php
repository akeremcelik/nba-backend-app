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
        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedSmallInteger('team_strength')->after('name')->default(0);
            $table->unsignedSmallInteger('home_strength')->after('team_strength')->default(0);
            $table->unsignedSmallInteger('away_strength')->after('home_strength')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('team_strength');
            $table->dropColumn('home_strength');
            $table->dropColumn('away_strength');
        });
    }
};
