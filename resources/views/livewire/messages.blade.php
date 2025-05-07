<div>
  <div>

    <button class="btn btn-ghost rounded" wire:click="toggleDrawer">
        <svg fill="#FFFFFF" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 324.143 324.143" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <g>
                    <g>
                        <g>
                            <circle cx="88.071" cy="164.571" r="19"></circle>
                            <circle cx="162.071" cy="164.571" r="19"></circle>
                            <path
                                d="M162.071,0C73.162,0,0.83,72.332,0.83,161.241c0,37.076,12.788,73.004,36.1,101.677 c-6.65,16.756-17.788,31.245-32.401,42.089c-2.237,1.66-3.37,4.424-2.94,7.177c0.429,2.754,2.349,5.042,4.985,5.942 c11.683,3.992,23.856,6.017,36.182,6.017c19.572,0,38.698-5.093,55.569-14.763c20.158,8.696,41.584,13.104,63.747,13.104 c88.909,0,161.241-72.333,161.241-161.242S250.98,0,162.071,0z M162.071,307.483c-21.32,0-41.881-4.492-61.11-13.351 c-2.292-1.057-4.959-0.891-7.102,0.443c-15.313,9.529-32.985,14.566-51.104,14.566c-6.053,0-12.065-0.564-17.981-1.684 c12.521-12.12,22.014-26.95,27.788-43.547c0.878-2.525,0.346-5.328-1.398-7.354C28.378,230.07,15.83,196.22,15.83,161.241 C15.83,80.604,81.434,15,162.071,15s146.241,65.604,146.241,146.241C308.313,241.88,242.709,307.483,162.071,307.483z">
                            </path>
                            <circle cx="236.071" cy="164.571" r="19"></circle>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
    </button>
    @if ($unreadMessagesCount > 0)
            <span class="absolute top-0 right-0 text-xs text-white bg-red-500 rounded-full px-2 py-1">
                {{ $unreadMessagesCount }}
            </span>
        @endif
  </div>

    <div class="drawer drawer-end">
        <input id="chat-drawer" type="checkbox" class="drawer-toggle" wire:model="showDrawer" />
        <div class="drawer-side z-50">
            <label for="chat-drawer" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                <div class="flex justify-between items-center mb-4 sticky top-0 z-10 bg-base-200 py-2">
                    @if ($selectedChatter)
                        <button wire:click="deselectChatter" class="btn btn-ghost rounded">←</button>
                    @endif
                    
                    <h2 class="text-xl font-bold">Chat</h2>
                    <label for="chat-drawer" class="btn btn-sm btn-circle btn-ghost">✕</label>
                </div>
                <div class="scrollable flex flex-col flex-grow overflow-y-auto">
                    <div class="chat-list transition-all ease-in-out duration-300"
                        style="display: {{ $selectedChatter ? 'none' : 'block' }};">
                        @foreach ($chatters as $chatter)
                            <button wire:click="selectChatter({{ $chatter['id'] }})"
                                class="flex items-center p-2 mb-2 w-full text-left rounded-lg hover:bg-base-300">
                                <div class="avatar mr-2">
                                    @if ($chatter['unread_messages'] > 0)
                                        <span class="absolute top-[-7px] left-[-7px] text-xs text-white bg-red-500 rounded-full px-2 py-1">
                                            {{ $chatter['unread_messages'] }}
                                        </span>
                                    @endif
                                    
                                    <div class="w-10 rounded-full">
                                        <img src="{{ $chatter['profile_picture'] ? Storage::url($chatter['profile_picture']) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                                            alt="{{ $chatter['name'] }}">
                                    </div>
                                </div>
                                <div class="flex flex-col w-full">
                                  <span class="font-medium">{{ $chatter['name'] }}</span>
                                  <div class="flex flex-row">
                                    <span class="text-sm text-gray-500">
                                      {{ \Illuminate\Support\Str::limit($chatter['last_message']['body'], 15, '...') }}
                                    </span>
                                    <span class="text-sm text-gray-500 ml-auto">
                                        {{ \Carbon\Carbon::parse($chatter['last_message']['created_at'])->diffForHumans() }}
                                    </span>
                                  </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    <div class="selected-chat transition-all ease-in-out duration-300 flex-col"
                        style="display: {{ $selectedChatter ? 'flex' : 'none' }};">
                        @if ($selectedChatter)
                            @foreach ($messages as $message)
                                <div class="mt-4 p-2 rounded-lg shadow-md {{ $message['user_id'] == auth()->id() ? 'bg-blue-500 text-white align-left ml-auto' : 'bg-gray-200 mr-auto' }} w-fit">
                                    {{ $message['body'] }}
                                    <div class="text-[10px] mt-1 {{ $message['user_id'] == auth()->id() ? 'text-white' : 'text-black' }}">
                                        {{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
                @if ($selectedChatter)
                    <div class="mt-4 sticky bottom-0 bg-base-200 p-2">
                        <div class="flex items-center space-x-2">
                            <input type="text" wire:model="messageText" wire:keydown.enter="sendMessage"
                                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Type a message..." />
                            <button wire:click="sendMessage" class="btn btn-primary rounded-lg">Send</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if ($conversationsCreated)
    @foreach ($chatters as $chatter)
      @script
        <script>
            const conversationId = @json($chatter['conversation_id']);
            window.Echo.private(`chat.${conversationId}`)
                .listen('MessageSent', (e) => {
                    console.log('Message received:', {message: e.message});
                    Livewire.dispatch('messageReceived', {message: e.message});
                });
        </script>
      @endscript
    @endforeach
@endif

@script
<script>
    // TODO: make this scroll to bottom when new message is received
    window.addEventListener('scrollToBottom', () => {
        var chatList = document.querySelector('.scrollable');
        chatList.scroll(0, chatList.scrollHeight)
        console.log(chatList.scrollTop, chatList.scrollHeight, chatList);
    });


</script>
@endscript
