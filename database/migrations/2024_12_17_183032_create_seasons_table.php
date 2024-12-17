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
        Schema::create('seasons', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('sport_id');
            $table->unsignedBigInteger('league_id');
            $table->unsignedBigInteger('tie_breaker_rule_id')->nullable();
            $table->string('name');
            $table->boolean('finished')->default(false);
            $table->boolean('pending')->default(false);
            $table->boolean('is_current')->default(false);
            $table->string('standing_method')->nullable();
            $table->date('starting_at')->nullable();
            $table->date('ending_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
