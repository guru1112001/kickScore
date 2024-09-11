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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // VARCHAR(255), NOT NULL
            $table->text('description'); // TEXT, NOT NULL
            $table->string('image')->nullable(); // VARCHAR(255), NULL
            $table->dateTime('schedule_at')->nullable(); // DATETIME, NULL
            $table->boolean('sent')->default(0); // TINYINT(1), NULL, default 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
