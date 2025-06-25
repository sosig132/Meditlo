<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('tutor_id');
            $table->string('stripe_payment_intent_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->decimal('platform_fee', 10, 2);
            $table->decimal('tutor_amount', 10, 2);
            $table->string('currency')->default('usd');
            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->json('payment_method_details')->nullable();
            $table->string('refund_status')->nullable();
            $table->string('stripe_refund_id')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('tutor_sessions')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['session_id', 'student_id']);
            $table->index(['tutor_id', 'status']);
            $table->index('status');
            $table->index('refund_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}; 