<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStripeAccount extends Model
{
    use HasFactory;

    protected $table = 'user_stripe_accounts';

    protected $fillable = [
        'user_id',
        'stripe_customer_id',
        'stripe_account_id',
        'stripe_onboarding_completed',
        'stripe_account_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
} 