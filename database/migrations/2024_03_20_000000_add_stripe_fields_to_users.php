<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stripe fields removed from users table. See new migration for user_stripe_accounts table.
    }

    public function down(): void
    {
        // Stripe fields removed from users table. See new migration for user_stripe_accounts table.
    }
}; 