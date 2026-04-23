<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('life_tracker_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('entry_date');
            $table->unsignedSmallInteger('water_ml')->default(0);
            $table->unsignedSmallInteger('sleep_hours')->default(0);
            $table->unsignedSmallInteger('calories_in')->default(0);
            $table->unsignedSmallInteger('calories_out')->default(0);
            $table->unsignedSmallInteger('exercise_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'entry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('life_tracker_entries');
    }
};
