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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            // $table->boolean('is_scheduled')->default(false);
            $table->timestamp('schedule_start')->nullable();
            $table->boolean('is_active')->default(true); // Active by default
            $table->unsignedBigInteger('created_by'); // Creator's user ID
            // $table->timestamp('schedule_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
