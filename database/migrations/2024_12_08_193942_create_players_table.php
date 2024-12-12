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
        Schema::create('players', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Unique ID from the API
            $table->unsignedBigInteger('sport_id')->nullable(); // Sport of the player
            $table->unsignedBigInteger('country_id')->nullable(); // Country of birth
            $table->unsignedBigInteger('nationality_id')->nullable(); // National team
            $table->string('city_id')->nullable(); // City of birth
            $table->unsignedBigInteger('position_id')->nullable(); // Position
            $table->unsignedBigInteger('detailed_position_id')->nullable(); // Detailed position
            $table->unsignedBigInteger('type_id')->nullable(); // Type of player
            $table->string('common_name')->nullable(); // Commonly known name
            $table->string('firstname')->nullable(); // First name
            $table->string('lastname')->nullable(); // Last name
            $table->string('name')->nullable(); // Full name
            $table->string('display_name')->nullable(); // Display name
            $table->string('image_path')->nullable(); // Path to player image
            $table->integer('height')->nullable(); // Height
            $table->integer('weight')->nullable(); // Weight
            $table->date('date_of_birth')->nullable(); // Date of birth
            $table->string('gender')->nullable(); // Gender
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
