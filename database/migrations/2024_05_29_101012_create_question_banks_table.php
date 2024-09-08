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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            // $table->string('Chapters')->nullable();
            // $table->integer('curriculum_id')->nullable();//curriculum id 
            $table->integer('question_bank_type_id')->nullable();
            $table->integer('question_bank_difficulty_id')->nullable();
            // $table->longText('short_description')->nullable();
            // $table->longText('questions_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_banks');
    }
};
