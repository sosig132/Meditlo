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
        Schema::table('users', function (Blueprint $table) {
            // Change the 'role' enum values
            $table->enum('role', ['admin', 'tutor', 'student'])
                  ->default('student')
                  ->change();

            // Remove the is_student and is_tutor columns
            $table->dropColumn(['is_student', 'is_tutor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the 'role' column back to the original enum
            $table->enum('role', ['admin', 'user'])->default('user')->change();

            // Add back the is_student and is_tutor columns
            $table->boolean('is_student')->default(false);
            $table->boolean('is_tutor')->default(false);
        });
    }
};
