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
  protected $listeners = ['messageReceived' => 'addMessage'];
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
    $this->chatters = $this->chatters->map(fn($chatter) => [
      'id' => $chatter->id,
      'name' => $chatter->name,
      'profile_picture' => $chatter->profile->profile_picture,
      'unread_messages' => $user->getConversationUnreadMessagesCount($this->getConversationId($chatter->id)),
      'last_message' => Conversation::find($this->getConversationId($chatter->id))->getLastMessage($this->getConversationId($chatter->id)),
      'conversation_id' => $this->getConversationId($chatter->id),
    ]);

    $this->chatters = $this->chatters->toArray();
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
    $this->conversationId = $this->getConversationId($chatterId);
    $this->messages = Conversation::find($this->conversationId)->getMessages($this->conversationId);
    $this->unreadMessagesCount -= $user->getConversationUnreadMessagesCount($this->conversationId);
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
    // Save the new message to the database
    $message = Message::create([
      'conversation_id' => $this->conversationId,
      'user_id' => Auth::id(),
      'body' => $this->messageText,
    ]);

    // Optionally broadcast the message via Pusher or any other event broadcaster
    broadcast(new \App\Events\MessageSent($message))->toOthers();

    // Add the message to the component’s messages array
    $this->messages[] = $message;

    // Clear the message input field
    $this->messageText = '';
  }

  public function addMessage($message)
  {
    \Log::info('Received message:', $message);
    $this->messages[] = $message;
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
