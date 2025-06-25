<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'status',
        'notes',
        'payment_status',
        'amount_paid',
        'paid_at',
        'stripe_payment_intent_id',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(TutorSession::class, 'session_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function markAsAttended(): bool
    {
        if ($this->status !== 'registered') {
            return false;
        }
        return $this->update(['status' => 'attended']);
    }

    public function cancel(): bool
    {
        if ($this->status === 'cancelled') {
            return false;
        }
        return $this->update(['status' => 'cancelled']);
    }

    public function hasPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPaymentPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

} 