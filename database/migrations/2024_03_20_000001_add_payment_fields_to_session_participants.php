<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('session_participants', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('status');
            $table->string('stripe_payment_intent_id')->nullable()->after('payment_status');
            $table->decimal('amount_paid', 10, 2)->nullable()->after('stripe_payment_intent_id');
            $table->timestamp('paid_at')->nullable()->after('amount_paid');
            $table->string('refund_status')->nullable()->after('paid_at');
            $table->string('stripe_refund_id')->nullable()->after('refund_status');
            $table->timestamp('refunded_at')->nullable()->after('stripe_refund_id');
            
            $table->index('payment_status');
            $table->index('stripe_payment_intent_id');
            $table->index('refund_status');
        });
    }

    public function down(): void
    {
        Schema::table('session_participants', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'stripe_payment_intent_id',
                'amount_paid',
                'paid_at',
                'refund_status',
                'stripe_refund_id',
                'refunded_at'
            ]);
            
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['stripe_payment_intent_id']);
            $table->dropIndex(['refund_status']);
        });
    }
}; 