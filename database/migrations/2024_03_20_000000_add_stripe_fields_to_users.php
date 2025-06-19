<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_customer_id')->nullable()->index();
            $table->string('stripe_account_id')->nullable()->index();
            $table->boolean('stripe_onboarding_completed')->default(false);
            $table->string('stripe_account_status')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_customer_id',
                'stripe_account_id',
                'stripe_onboarding_completed',
                'stripe_account_status'
            ]);
        });
    }
}; 