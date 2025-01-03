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
        Schema::create('sportmonkteams', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('name')->nullable();
            $table->string('short_code')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('founded')->nullable();
            $table->string('type')->nullable();
            $table->boolean('placeholder')->nullable();
            $table->unsignedBigInteger('last_played_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sportmonkteams');
    }
};
