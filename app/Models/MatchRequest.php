<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
        'message',
        'response_message',
    ];
    protected $casts = [
        'status' => 'string',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function markAsAccepted()
    {
        $this->update(['status' => 'accepted']);
    }
    public function markAsRejected()
    {
        $this->update(['status' => 'rejected']);
    }
}
