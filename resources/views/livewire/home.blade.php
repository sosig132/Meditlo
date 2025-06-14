<div class="container mx-auto">
    <div class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 w-full flex-1">
        <x-input label="Name" wire:model="personName" />
        <div class="filters flex flex-row flex-wrap gap-2.5 sm:flex-row sm:space-x-4 mt-4 mb-3">
            <div class="w-1/3 min-w-[200px] sm:w-1/5 bg-gray-800 sm:mb-0 mb-3">
                <x-checkbox-select :options="$optionsSubjects" type="subjects" wireModel="selectedSubjects" />
            </div>
            <div class="w-1/3 sm:w-1/5 min-w-[200px] bg-gray-800 sm:mb-0 mb-3">
                <x-checkbox-select :options="$optionsLevels" type="levels" wireModel="selectedLevels" />
            </div>
            <div class="w-1/3 sm:w-1/5 min-w-[200px] bg-gray-800">
                <x-checkbox-select :options="$optionsStyles" type="styles" wireModel="selectedStyles" />
            </div>
            <div class="w-1/3 sm:w-1/5 min-w-[200px] bg-gray-800">
                <div wire:ignore class="border input-primary rounded">
                    <select id="sort" wire:model="sortBy" class="checkbox-select"
                    wire:change="sortUsers">
                        @foreach ($sorts as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <button class="btn btn-primary" wire:click="getRecommendations">Filter</button>
        </div>
    </div>
    <div class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 w-full flex-1 mt-5">
        <h2 class="text-2xl font-bold mb-4">Results</h2>

        <div class="gap-4 w-full flex flex-col">
            @if ($users->isEmpty())
                <p class="text-gray-400">No users found matching your criteria.</p>
            @else
                @foreach ($users as $user)
                    <div class="bg-gray-700 p-4 rounded-lg shadow-md w-full flex flex-row">
                        <div class="avatar h-10 w-10 mr-4">
                            <div class="w-10 rounded-full">
                                <img src="{{ $user->profile->user_photo ? Storage::url($user->profile->user_photo) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                                    alt="Profile Photo">
                            </div>
                        </div>
                        <div class="flex flex-col">
                          <div class="flex flex-row items-center gap-5">
                            <a href="/profile/{{ $user->id }}">
                                <h3 class="text-xl font-semibold mb-1">{{ $user->name }}</h3>
                            </a>
                            @if ($user->role == 'tutor')
                            <div class="flex items-center gap-1">
                              <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mt-[2px] text-yellow-400"

                           fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.174c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.92-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.176 0l-3.38 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.966a1 1 0 00-.364-1.118L2.03 9.394c-.783-.57-.38-1.81.588-1.81h4.174a1 1 0 00.95-.69l1.286-3.967z" />
                    </svg>{{ $user->getAverageRating() }}({{ $user->getRatingCount() }})
                            </div> 
                            @endif
                          </div>
                            <div class="flex-row gap-3 hidden md:flex">
                                @foreach ($user->answers as $answer)
                                    @if ($answer->possibleAnswer->question_number == 2)
                                        <p class="bg-emerald-600  text-gray-100 rounded px-2">
                                            {{ $answer->possibleAnswer->answer }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <button class="btn btn-primary ml-auto" wire:click="showUserModal({{ $user->id }})">Send
                            request</button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @if (!$users->isEmpty())
        <div>
            <dialog id="user_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
                <div class="modal-box flex flex-col">
                    <button wire:click="closeUserModal"
                        class="absolute top-0 right-0 p-2 text-gray-500 hover:text-gray-800 btn btn-ghost">
                        <span class="text-2xl">&times;</span> <!-- The X character -->
                    </button>
                    <div class="avatar h-20 w-20 mx-auto">
                        <div class="w-20 h-20 rounded-full">
                            <img src="{{ $modalUser?->profile->photo ? Storage::url($modalUser?->profile->photo) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                                alt="Profile Photo">
                        </div>
                    </div>
                    <h3 class="text-center text-xl font-semibold mt-4">{{ $modalUser?->name }}</h3>
                    <p class="text-center mt-2">{{ $modalUser?->profile->about_me }}</p>
                    <div class="mt-2 flex flex-row gap-3 justify-center">
                        @foreach ($user->answers as $answer)
                            @if ($answer->possibleAnswer->question_number == 2)
                                <p class="bg-emerald-600  text-gray-100 rounded px-2">
                                    {{ $answer->possibleAnswer->answer }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-2 flex flex-row gap-3 justify-center text-nowrap">
                        @foreach ($user->answers as $answer)
                            @if ($answer->possibleAnswer->question_number == 4)
                                <p class="bg-amber-600  text-gray-100 rounded px-2">
                                    {{ $answer->possibleAnswer->answer }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-2 flex flex-row gap-3 justify-center">
                        @foreach ($user->answers as $answer)
                            @if ($answer->possibleAnswer->question_number == 3)
                                <p class="bg-blue-600  text-gray-100 rounded px-2">
                                    {{ $answer->possibleAnswer->answer }}</p>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <x-form wire:submit.prevent="sendMatchRequest({{ $modalUser?->id }})">
                            <x-slot:actions>
                                <x-button onclick="user_modal.close()" label="Cancel" />
                                <x-button label="Trimite cerere" class="btn-primary" type="submit"
                                    spinner="sendMatchRequest" />
                            </x-slot:actions>
                        </x-form>
                    </div>
                </div>
            </dialog>
        </div>
    @endif
</div>

@script
    <script>
        window.addEventListener('show-modal', () => {
            const modal = document.getElementById('user_modal');
            modal.showModal();
        })

        window.addEventListener('close-modal', () => {
            const modal = document.getElementById('user_modal');
            modal.close();
        })
        window.userId = @json(Auth::id());
    </script>
@endscript
@script
    <script type="module">
        window.addEventListener('DOMContentLoaded', () => {
            new TomSelect("#sort", {
                allowEmptyOption: true,
                placeholder: "Sort by",
                render: {
                    no_results: function() {
                        return '<p>No results found</p>';
                    }
                },
            });
        })
    </script>
@endscript
