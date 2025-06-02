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
        Schema::table('answers', function (Blueprint $table) {
            // Ensure the column exists and is unsigned
            $table->unsignedBigInteger('answer_id')->change();

            // Add the foreign key constraint
            $table->foreign('answer_id')
                  ->references('id')
                  ->on('possible_answers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            //
        });
    }
};
