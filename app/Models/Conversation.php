<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = ['user_one_id', 'user_two_id'];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Get the second user (the recipient).
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get all messages in this conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Scope to find a conversation between two users.
     */
    public static function between($userAId, $userBId)
    {
        return self::where(function ($query) use ($userAId, $userBId) {
            $query->where('user_one_id', $userAId)
                  ->where('user_two_id', $userBId);
        })->orWhere(function ($query) use ($userAId, $userBId) {
            $query->where('user_one_id', $userBId)
                  ->where('user_two_id', $userAId);
        })->first();
    }

    public function getMessages($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->orderBy('created_at', 'asc')
                      ->get()
                      ->toArray();
    }

    public function getUnreadMessagesCount($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->where('is_read', false)
                      ->count();
    }
    public function getLastMessageTime($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->orderBy('created_at', 'desc')
                      ->first()
                      ->created_at;
    }
    public function getLastMessageSender($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->orderBy('created_at', 'desc')
                      ->first()
                      ->user_id;
    }
    public function getLastMessageBody($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->orderBy('created_at', 'desc')
                      ->first()
                      ->body;
    }
    public function getLastMessage($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
                      ->orderBy('created_at', 'desc')
                      ->first();
    }
    public static function markMessagesAsRead($conversationId, $userId)
    {
        Message::where('conversation_id', $conversationId)
               ->where('read', false)
               ->where('user_id', '!=', $userId)
               ->update(['read' => true]);
    }

}
