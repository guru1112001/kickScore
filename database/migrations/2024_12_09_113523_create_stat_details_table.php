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
        Schema::create('stat_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // Use API-provided ID as the primary key.
            $table->unsignedBigInteger('player_statistic_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stat_details');
    }
};
