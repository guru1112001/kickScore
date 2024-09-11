<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_bank_id');
            $table->longText('question');
            $table->string('question_type');
            $table->string('difficulty')->nullable();
            $table->string('topic')->nullable();
            $table->decimal('Points', 11, 1)->default(0.0);
            $table->longText('hint')->nullable();
            $table->longText('answer')->nullable();
            $table->timestamps();
            
            // Foreign key constraint (if question_bank_id is related to another table)
            $table->foreign('question_bank_id')->references('id')->on('question_banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};