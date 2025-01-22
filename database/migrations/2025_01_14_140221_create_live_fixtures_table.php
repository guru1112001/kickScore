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
        Schema::create('live_fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id')->nullable();
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->unsignedBigInteger('league_id')->nullable();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->string('name')->nullable(); // Fixture name
            $table->dateTime('starting_at')->nullable();
            $table->text('details')->nullable();
            $table->json('participants')->nullable();
            $table->json('weather_report')->nullable();
            $table->json('venue')->nullable();
            $table->json('formations')->nullable();
            $table->json('metadata')->nullable();
            $table->json('lineups')->nullable();
            $table->json('timeline')->nullable();
            $table->json('trends')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livefixtures');
    }
};
