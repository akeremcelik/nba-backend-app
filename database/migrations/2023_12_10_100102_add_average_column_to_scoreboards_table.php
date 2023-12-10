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
        Schema::table('scoreboards', function (Blueprint $table) {
            $table->smallInteger('average')->after('scores_in')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scoreboards', function (Blueprint $table) {
            $table->dropColumn('average');
        });
    }
};
