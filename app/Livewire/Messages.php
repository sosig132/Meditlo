<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Messages extends Component
{
  public $messages = [];
  public $showDrawer = false;
  public $unreadMessagesCount = 0;
  public $chatters = [];
  public $messageText = '';
  public $conversationId = null;
  public $selectedChatter = null;
  public $selectedChatterName = '';
  protected $listeners = ['messageReceived'];
  public $conversationsCreated = false;
  public function mount()
  {
    $this->showDrawer = false;
    $user = Auth::user();

    if ($user->role === 'student') {
      $this->chatters = $user->tutors()->get();
    }
    if ($user->role === 'tutor') {
      $this->chatters = $user->students()->get();
    }
    
    $this->createConversationsForUser();
    if (!$this->chatters) {
      $this->chatters = collect();
    }
    $this->chatters = $this->chatters->map(callback: fn($chatter) => [
      'id' => $chatter->id,
      'name' => $chatter->name,
      'profile_picture' => $chatter->profile->user_photo,
      'unread_messages' => $user->getConversationUnreadMessagesCount($this->getConversationId($chatter->id)),
      'last_message' => Conversation::find($this->getConversationId($chatter->id))->getLastMessage($this->getConversationId($chatter->id)),
      'conversation_id' => $this->getConversationId($chatter->id),
    ]);

    $this->chatters = $this->chatters->toArray();
    $this->unreadMessagesCount = $user->getUnreadMessagesCount();
  }

  public function createConversationsForUser()
  {
    $userId = Auth::user()->id;
    foreach ($this->chatters as $chatter) {
      $chatterId = $chatter['id'];
      $conversation = Conversation::between($userId, $chatterId);

      if (!$conversation) {
        Conversation::create([
          'user_one_id' => $userId,
          'user_two_id' => $chatterId,
        ]);
      }
    }
    $this->dispatch('conversationsCreated');
    $this->conversationsCreated = true;
  }

  public function selectChatter($chatterId)
  {
    $user = Auth::user();
    $this->selectedChatter = $chatterId;
    $this->selectedChatterName = collect($this->chatters)->firstWhere('id', $chatterId)['name'];
    $this->conversationId = $this->getConversationId($chatterId);
    Conversation::markMessagesAsRead($this->conversationId, $user->id);
    $this->messages = Conversation::find($this->conversationId)->getMessages($this->conversationId);
    $this->unreadMessagesCount = $user->getUnreadMessagesCount();
    $this->chatters = collect($this->chatters)->map(function ($chatter) use ($chatterId) {
      if ($chatter['id'] == $chatterId) {
        $chatter['unread_messages'] = 0;
      }
      return $chatter;
    })->toArray();
    $this->dispatch('scrollToBottom');
  }

  public function goBack()
  {
    $this->selectedChatter = null;
    $this->conversationId = null;
    $this->messages = [];
    $this->dispatch('scrollToTop');
  }

  public function getConversationId($chatterId)
  {
    $userId = Auth::user()->id;
    $conversation = Conversation::between($userId, $chatterId);

    if (!$conversation) {
      $conversation = Conversation::create([
        'user_one_id' => $userId,
        'user_two_id' => $chatterId,
      ]);
    }

    return $conversation->id;
  }

  public function sendMessage()
  {
    if (trim($this->messageText) === '')
      return;

    $message = Message::create([
      'conversation_id' => $this->conversationId,
      'user_id' => Auth::id(),
      'body' => $this->messageText,
    ]);

    broadcast(new \App\Events\MessageSent($message))->toOthers();

    $this->messages[] = $message;

    $this->messageText = '';
    $this->dispatch('scrollToBottom');
  }

  public function messageReceived($message)
  {
    \Log::info('Received message:', $message);
    $this->messages[] = $message;
    $this->unreadMessagesCount++;
    $chatterId = $message['user']['id'];
    $chatterConversationId = $this->getConversationId($chatterId);
    $chatter = collect($this->chatters)->firstWhere('id', $chatterId);
    if ($chatter) {
      $chatter['unread_messages']++;
      $this->chatters = collect($this->chatters)->map(function ($chatter) use ($chatterId, $chatterConversationId) {
        if ($chatter['id'] == $chatterId) {
          $chatter['unread_messages']++;
          $chatter['last_message'] = Conversation::find($chatterConversationId)->getLastMessage($chatterConversationId);
        }
        return $chatter;
      });
    }
  }

  public function deselectChatter()
  {
    $this->selectedChatter = null;
    $this->conversationId = null;
    $this->messages = [];
    $this->dispatch('scrollToTop');
  }
  
  public function toggleDrawer()
  {
    $this->showDrawer = !$this->showDrawer;
  }
  public function render()
  {
    return view('livewire.messages');
  }
}
