<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConversation extends Model
{
    use HasFactory;

    protected $table = 'users_conversations';
    protected $fillable = ['user_id', 'conversation_id', 'is_admin', 'joined_at', 'left_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
} 