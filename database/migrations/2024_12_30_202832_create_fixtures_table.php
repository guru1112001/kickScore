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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('sport_id')->nullable(); // Sport ID
            $table->unsignedBigInteger('league_id')->nullable(); // League ID
            $table->unsignedBigInteger('season_id')->nullable(); // Season ID
            $table->unsignedBigInteger('stage_id')->nullable(); // Stage ID
            $table->unsignedBigInteger('group_id')->nullable(); // Group ID
            $table->unsignedBigInteger('aggregate_id')->nullable(); // Aggregate ID
            $table->unsignedBigInteger('state_id')->nullable(); // State ID
            $table->unsignedBigInteger('round_id')->nullable(); // Round ID
            $table->unsignedBigInteger('venue_id')->nullable(); // Venue ID
            $table->string('name')->nullable(); // Fixture name
            $table->dateTime('starting_at')->nullable(); // Starting time
            $table->string('result_info')->nullable(); // Final result info
            $table->string('leg')->nullable(); // Fixture leg
            $table->text('details')->nullable(); // Details about the fixture
            $table->integer('length')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
