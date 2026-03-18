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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('npm')->unique()->nullable();
            $table->integer('level')->default(1);
            $table->integer('current_exp')->default(0);
            $table->integer('total_coins')->default(0);
            $table->string('rank_title')->nullable();
            $table->json('skill_distribution')->nullable(); // Cached snapshot of radar data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
