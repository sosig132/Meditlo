<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Messages extends Component
{
  use LivewireAlert;

  public $messages = [];
  public $showDrawer = false;
  public $unreadMessagesCount = 0;
  public $chatters = [];
  public $messageText = '';
  public $conversationId = null;
  public $selectedChatter = null;
  public $selectedChatterName = '';
  public $showCreateGroupModal = false;
  public $groupName = '';
  public $selectedStudents = [];
  public $showGroupSettingsModal = false;
  public $availableStudents = [];
  public $currentGroupParticipants = [];
  public $selectedGroupParticipants = [];
  public $conversationsCreated = false;

  protected $listeners = ['messageReceived'];

  public function mount()
  {
    $this->showDrawer = false;
    $user = Auth::user();

    // Ensure private conversations exist between the user and their related users
    if ($user->isTutor()) {
      $relatedUsers = $user->students;
    } else {
      $relatedUsers = [$user->tutor];
    }

    foreach ($relatedUsers as $relatedUser) {
      if (!$relatedUser)
        continue; // Skip if no related user (e.g., student without tutor)

      // Check if a private conversation already exists
      $existingConversation = Conversation::where('is_group', false)
        ->whereHas('participants', function ($query) use ($user, $relatedUser) {
          $query->whereIn('users.id', [$user->id, $relatedUser->id]);
        })
        ->whereDoesntHave('participants', function ($query) use ($user, $relatedUser) {
          $query->whereNotIn('users.id', [$user->id, $relatedUser->id]);
        })
        ->first();

      if (!$existingConversation) {
        // Create new private conversation
        $conversation = Conversation::create([
          'is_group' => false,
          'created_by' => $user->id,
        ]);

        // Add both users as participants
        $conversation->addParticipant($user->id);
        $conversation->addParticipant($relatedUser->id);
      }
    }

    $this->loadConversations();
    $this->conversationsCreated = true;
  }

  public function loadConversations()
  {
    $user = Auth::user();
    $conversations = $user->conversations()
      ->with([
        'participants',
        'messages' => function ($query) {
          $query->latest();
        }
      ])
      ->get();

    $this->chatters = $conversations->map(function ($conversation) use ($user) {
      $otherParticipants = $conversation->participants->where('id', '!=', $user->id);
      $name = $conversation->is_group
        ? $conversation->name
        : $otherParticipants->first()->name;

      $lastMessage = $conversation->getLastMessage($conversation->id);

      return [
        'id' => $conversation->id,
        'name' => $name,
        'is_group' => $conversation->is_group,
        'profile_picture' => $conversation->is_group
          ? null
          : $otherParticipants->first()->profile->user_photo,
        'unread_messages' => $user->getConversationUnreadMessagesCount($conversation->id),
        'last_message' => $lastMessage,
        'has_messages' => $lastMessage !== null,
        'last_message_time' => $lastMessage ? $lastMessage->created_at : $conversation->created_at,
        'conversation_id' => $conversation->id,
        'participants' => $conversation->participants->pluck('name')->toArray(),
      ];
    })
    ->sort(function ($a, $b) {
      if ($a['has_messages'] !== $b['has_messages']) {
        return $b['has_messages'] ? 1 : -1;
      }
      return $b['last_message_time']->timestamp - $a['last_message_time']->timestamp;
    })
    ->values()
    ->toArray();

    $this->unreadMessagesCount = $user->getUnreadMessagesCount();
    $this->conversationsCreated = true;
    $this->dispatch('conversationsUpdated', ['chatters' => $this->chatters]);
  }

  public function selectChatter($conversationId)
  {
    $user = Auth::user();
    $conversation = Conversation::find($conversationId);

    if (!$conversation)
      return;

    $this->selectedChatter = $conversationId;
    $this->selectedChatterName = $conversation->is_group
      ? $conversation->name
      : $conversation->participants->where('id', '!=', $user->id)->first()->name;

    $this->conversationId = $conversationId;
    $conversation->markMessagesAsRead($conversationId, $user->id);
    $this->messages = $conversation->messages;
    $this->unreadMessagesCount = $user->getUnreadMessagesCount();

    $this->chatters = collect($this->chatters)->map(function ($chatter) use ($conversationId) {
      if ($chatter['conversation_id'] == $conversationId) {
        $chatter['unread_messages'] = 0;
      }
      return $chatter;
    })->toArray();

    $this->dispatch('scrollToBottom');
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
    $message = Message::find($message['id']);
    $this->messages[] = $message;

    $conversation = Conversation::find($message['conversation_id']);
    if ($conversation) {
      $this->chatters = collect($this->chatters)->map(function ($chatter) use ($conversation, $message) {
        if ($chatter['conversation_id'] == $conversation->id) {
          if ($this->selectedChatter !== $conversation->id) {
            $chatter['unread_messages']++;
            $this->unreadMessagesCount++;
          } else {
            $conversation->markMessagesAsRead($conversation->id, Auth::id());
          }
          $chatter['last_message'] = $message;
        }
        return $chatter;
      })->toArray();
    }
  }

  public function toggleDrawer()
  {
    $this->showDrawer = !$this->showDrawer;
  }

  public function createGroupChat()
  {
    $this->validate([
      'groupName' => 'required|min:3|max:50',
      'selectedStudents' => 'required|array|min:1',
    ]);

    $conversation = Conversation::create([
      'name' => $this->groupName,
      'is_group' => true,
      'created_by' => Auth::id(),
    ]);

    // Add creator as admin
    $conversation->addParticipant(Auth::id(), true);

    // Add selected students
    foreach ($this->selectedStudents as $studentId) {
      $conversation->addParticipant($studentId);
    }

    $this->showCreateGroupModal = false;
    $this->loadConversations();
    $this->alert('success', 'Group chat created successfully!');
    $this->groupName = '';
    $this->selectedStudents = [];
  }

  public function showGroupSettings()
  {
    if (!$this->selectedChatter)
      return;

    $conversation = Conversation::find($this->selectedChatter);
    if (!$conversation->is_group || !$conversation->isAdmin(Auth::id())) {
      $this->alert('error', 'You do not have permission to manage this group.');
      return;
    }

    $this->currentGroupParticipants = $conversation->participants->pluck('id')->toArray();
    $this->selectedGroupParticipants = $this->currentGroupParticipants;
    $this->availableStudents = Auth::user()->students;

    $this->showGroupSettingsModal = true;
    $this->dispatch('showGroupSettings');
  }

  public function updateGroupParticipants()
  {
    $conversation = Conversation::find($this->selectedChatter);
    if (!$conversation->is_group || !$conversation->isAdmin(Auth::id())) {
      $this->alert('error', 'You do not have permission to manage this group.');
      return;
    }

    // Ensure the admin is always included in the participants
    if (!in_array(Auth::id(), $this->selectedGroupParticipants)) {
      $this->selectedGroupParticipants[] = Auth::id();
    }

    // Sync all participants at once
    $conversation->syncParticipants($this->selectedGroupParticipants, Auth::id());

    $this->loadConversations();
    $this->showGroupSettingsModal = false;
    $this->alert('success', 'Group participants updated successfully!');
  }

  public function deselectChat()
  {
    $this->selectedChatter = null;
    $this->selectedChatterName = '';
    $this->conversationId = null;
    $this->messages = [];
  }

  public function render()
  {
    return view('livewire.messages');
  }
}
