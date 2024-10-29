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
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('league_id')->nullable();
            $table->integer('sport_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('active')->nullable();
            $table->string('short_code')->nullable();
            $table->string('image_path')->nullable();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('last_played_at')->nullable();
            $table->integer('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
