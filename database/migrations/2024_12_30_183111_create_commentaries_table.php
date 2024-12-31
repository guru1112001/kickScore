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
        Schema::create('commentaries', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('fixture_id')->nullable();
            $table->text('comment')->nullable();
            $table->integer('minute')->nullable();
            $table->integer('extra_minute')->nullable();
            $table->boolean('is_goal')->default(false);
            $table->boolean('is_important')->default(false);
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->index('fixture_id');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaries');
    }
};
