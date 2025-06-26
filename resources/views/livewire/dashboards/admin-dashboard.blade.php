<div class="p-5">
    <h1 class="text-center text-3xl">Admin Dashboard</h1>
    <hr class="my-4">
    
    <!-- Edit Answers Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl">Edit Your Profile Answers</h2>
            <button 
                class="btn btn-primary" 
                onclick="edit_answers_modal.showModal()">
                Edit Answers
            </button>
        </div>
        <p class="text-gray-600 mb-4">Update your preferences for subjects, learning style, and education level.</p>
    </div>
    
    <h2 class="text-2xl mb-4">Answers to profile creation questions</h2>
    <div class="flex flex-col mx-10">
        @foreach ($questions as $questionNumber)
            <div>
                <h1>Answers for Question {{ $questionNumber }}:
                    @switch($questionNumber)
                        @case(1)
                            (What type of account?)
                        @break

                        @case(2)
                            (What subjects are you looking for?)
                        @break

                        @case(3)
                            (Online or in person?)
                        @break

                        @case(4)
                            (What education level are you interested in?)
                        @break
                    @endswitch
                </h1>

                @foreach ($possibleAnswers[$questionNumber] as $answer)
                    <div class="w-fit cursor-pointer" wire:click="deleteAnswer({{$answer['id']}})">
                        <p>{{ $answer['answer'] }}</p>
                    </div>
                @endforeach

                <x-form wire:submit.prevent="addAnswer({{ $questionNumber }})" class="col-span-3">
                    <x-input label="Answer" wire:model.defer="answers.{{ $questionNumber }}" />
                    <x-slot name="actions">
                        <x-button label="Add Answer" class="btn-primary" type="submit" />
                    </x-slot>
                </x-form>
            </div>
        @endforeach
    </div>
    <hr class="my-4">
    <h2 class="text-2xl mb-4">Users</h2>

    <div class="flex flex-col mx-10">
        @foreach ($users as $user)
            <div class="mb-4 p-4 border rounded-lg flex flex-row justify-between items-center">
                <div>
                    <a href="/profile/{{ $user->id }}">
                        <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                    </a>
                    <p>Email: {{ $user->email }}</p>
                </div>
                <button class="btn bg-red-800 mt-2 color-white" onclick="delete_user_modal.showModal()" wire:click="selectUser({{$user->id}})">Delete
                    user</button>
            </div>
        @endforeach
    </div>

    <dialog id="delete_user_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete User</h3>
            <p class="py-4">Are you sure you want to delete this user?</p>
            <div class="w-full flex justify-end gap-2">
              <x-button label="Cancel" onclick="delete_user_modal.close()" />
              <x-button label="Delete" class="btn bg-red-800 color-white" wire:click="deleteUser({{$selectedUser}})" onclick="delete_user_modal.close()" />
            </div>
        </div>
    </dialog>

    <!-- Edit Answers Modal -->
    <dialog id="edit_answers_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
            <button onclick="edit_answers_modal.close()" class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
                <span class="text-2xl">&times;</span>
            </button>
            <livewire:edit-answers />
        </div>
    </dialog>

    <div>
      <h2 class="text-2xl mb-4">Run teacher ratings CRON</h2>
      <p class="mb-4">This will update the average global rating</p>
      <x-button label="Run CRON" class="btn-primary" wire:click="runCron" />
    </div>
</div>
