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
        Schema::table('conversations', function (Blueprint $table) {
            // First drop the foreign key constraints
            $table->dropForeign(['user_one_id']);
            $table->dropForeign(['user_two_id']);
            
            // Then drop the unique index
            $table->dropUnique(['user_one_id', 'user_two_id']);
            
            // Now we can safely drop the columns
            $table->dropColumn(['user_one_id', 'user_two_id']);
        });

        Schema::create('users_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->boolean('is_admin')->default(false);
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'conversation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_conversations');

        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('user_one_id')->constrained('users');
            $table->foreignId('user_two_id')->constrained('users');
            $table->unique(['user_one_id', 'user_two_id']);
        });
    }
}; 