<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['is_group', 'name', 'created_by'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'users_conversations')
            ->withPivot('is_admin', 'joined_at', 'left_at')
            ->whereNull('users_conversations.left_at');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getLastMessage($conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->latest()
            ->first();
    }

    public function markMessagesAsRead($conversationId, $userId)
    {
        Message::where('conversation_id', $conversationId)
            ->where('user_id', '!=', $userId)
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function addParticipant($userId, $isAdmin = false)
    {
        $this->participants()->attach($userId, [
            'is_admin' => $isAdmin,
            'joined_at' => now()
        ]);
    }

    public function removeParticipant($userId)
    {
        $this->participants()->updateExistingPivot($userId, [
            'left_at' => now()
        ]);
    }

    public function isAdmin($userId)
    {
        return $this->participants()
            ->where('user_id', $userId)
            ->where('is_admin', true)
            ->exists();
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
}
