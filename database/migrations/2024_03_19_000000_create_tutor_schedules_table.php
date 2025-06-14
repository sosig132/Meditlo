<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('type')->default('one_on_one'); // one_on_one, group
            $table->integer('max_students')->nullable(); // null for one_on_one, number for group
            $table->decimal('price', 10, 2)->nullable(); // price per student
            $table->string('status')->default('scheduled'); // scheduled, in_progress, completed, cancelled
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // weekly, biweekly, monthly
            $table->date('recurrence_end_date')->nullable();
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['tutor_id', 'start_time']);
            $table->index('type');
            $table->index('status');
        });

        Schema::create('session_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('student_id');
            $table->string('status')->default('registered'); // registered, attended, cancelled
            $table->text('notes')->nullable();
            $table->foreign('session_id')->references('id')->on('tutor_sessions')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure a student can only register once per session
            $table->unique(['session_id', 'student_id']);
            
            // Indexes for better query performance
            $table->index(['session_id', 'status']);
            $table->index(['student_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_participants');
        Schema::dropIfExists('tutor_sessions');
    }
}; 