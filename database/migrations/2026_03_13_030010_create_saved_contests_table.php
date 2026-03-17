<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_contests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('contest_id')->constrained('contests')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'contest_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_contests');
    }
};
