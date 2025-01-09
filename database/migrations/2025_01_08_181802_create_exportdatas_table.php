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
        Schema::create('exportdatas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id');
            // $table->unsignedBigInteger('team_id')->nullable();
            // $table->unsignedBigInteger('player_id')->nullable();
            $table->text('commentary')->nullable();
            $table->integer('minute')->nullable();
            $table->unsignedBigInteger('team_a')->nullable();
            $table->unsignedBigInteger('team_b')->nullable();
            // $table->string('event_type')->nullable(); // E.g., goal, foul, substitution
            // $table->unsignedBigInteger('event_related_player_id')->nullable(); // If an event relates to another player
            
            // Foreign keys (optional)
            $table->foreign('team_a')->references('id')->on('sportmonkteams')->onDelete('set null');
            $table->foreign('team_b')->references('id')->on('sportmonkteams')->onDelete('set null');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade');
            // $table->foreign('team_id')->references('id')->on('sportmonkteams')->onDelete('cascade');
            // $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exportdatas');
    }
};
