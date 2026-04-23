<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lifestyle_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('score_date');
            $table->unsignedSmallInteger('score')->default(0);
            $table->enum('reward_type', ['reward', 'punishment', 'neutral'])->default('neutral');
            $table->string('reward_message')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'score_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lifestyle_scores');
    }
};
