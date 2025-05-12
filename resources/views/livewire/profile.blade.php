<div
    class="flex flex-col profile:flex-row items-start justify-center md:space-y-4 profile:space-y-0 profile:space-x-4 sm:justify-center">
    <div class="flex flex-col max-w-4xl w-full">
        <div
            class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 max-w-4xl w-full profile:mx-8 profile:mt-4 flex-1">
            <div class="flex flex-col profile:flex-row items-center space-y-4 profile:space-y-0 profile:space-x-8">
                <div class="relative group">
                    <img src="{{ $photo ? asset('storage/' . $photo) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                        id="profile-image" alt="Profile Photo"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-700 cursor-pointer transition duration-300 ease-in-out transform group-hover:scale-105"
                        wire:click="triggerUpload">

                    <div id="overlay"
                        class="cursor-pointer absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        wire:click="triggerUpload">
                        <span class="text-white text-sm font-semibold">Change Photo</span>
                    </div>

                    <input type="file" id="photo-upload" wire:model="photo" class="hidden" accept="image/*">
                </div>
                <div class="text-center profile:text-left">
                    <h2 class="text-3xl font-semibold text-gray-100">{{ $user->name }}</h2>
                    <p class="text-gray-300 mt-2">{{ ucfirst($user->role) }}</p>
                    <div class="mt-6">
                        <p class="text-gray-300 flex items-center">
                            <strong><svg class="mr-3" fill="#ffffff" height="18px" width="18px" version="1.1"
                                    id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 473.806 473.806"
                                    xml:space="preserve">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g>
                                                <path
                                                    d="M374.456,293.506c-9.7-10.1-21.4-15.5-33.8-15.5c-12.3,0-24.1,5.3-34.2,15.4l-31.6,31.5c-2.6-1.4-5.2-2.7-7.7-4 c-3.6-1.8-7-3.5-9.9-5.3c-29.6-18.8-56.5-43.3-82.3-75c-12.5-15.8-20.9-29.1-27-42.6c8.2-7.5,15.8-15.3,23.2-22.8 c2.8-2.8,5.6-5.7,8.4-8.5c21-21,21-48.2,0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5c-6-6.2-12.3-12.6-18.8-18.6 c-9.7-9.6-21.3-14.7-33.5-14.7s-24,5.1-34,14.7c-0.1,0.1-0.1,0.1-0.2,0.2l-34,34.3c-12.8,12.8-20.1,28.4-21.7,46.5 c-2.4,29.2,6.2,56.4,12.8,74.2c16.2,43.7,40.4,84.2,76.5,127.6c43.8,52.3,96.5,93.6,156.7,122.7c23,10.9,53.7,23.8,88,26 c2.1,0.1,4.3,0.2,6.3,0.2c23.1,0,42.5-8.3,57.7-24.8c0.1-0.2,0.3-0.3,0.4-0.5c5.2-6.3,11.2-12,17.5-18.1c4.3-4.1,8.7-8.4,13-12.9 c9.9-10.3,15.1-22.3,15.1-34.6c0-12.4-5.3-24.3-15.4-34.3L374.456,293.506z M410.256,398.806 C410.156,398.806,410.156,398.906,410.256,398.806c-3.9,4.2-7.9,8-12.2,12.2c-6.5,6.2-13.1,12.7-19.3,20 c-10.1,10.8-22,15.9-37.6,15.9c-1.5,0-3.1,0-4.6-0.1c-29.7-1.9-57.3-13.5-78-23.4c-56.6-27.4-106.3-66.3-147.6-115.6 c-34.1-41.1-56.9-79.1-72-119.9c-9.3-24.9-12.7-44.3-11.2-62.6c1-11.7,5.5-21.4,13.8-29.7l34.1-34.1c4.9-4.6,10.1-7.1,15.2-7.1 c6.3,0,11.4,3.8,14.6,7c0.1,0.1,0.2,0.2,0.3,0.3c6.1,5.7,11.9,11.6,18,17.9c3.1,3.2,6.3,6.4,9.5,9.7l27.3,27.3 c10.6,10.6,10.6,20.4,0,31c-2.9,2.9-5.7,5.8-8.6,8.6c-8.4,8.6-16.4,16.6-25.1,24.4c-0.2,0.2-0.4,0.3-0.5,0.5 c-8.6,8.6-7,17-5.2,22.7c0.1,0.3,0.2,0.6,0.3,0.9c7.1,17.2,17.1,33.4,32.3,52.7l0.1,0.1c27.6,34,56.7,60.5,88.8,80.8 c4.1,2.6,8.3,4.7,12.3,6.7c3.6,1.8,7,3.5,9.9,5.3c0.4,0.2,0.8,0.5,1.2,0.7c3.4,1.7,6.6,2.5,9.9,2.5c8.3,0,13.5-5.2,15.2-6.9 l34.2-34.2c3.4-3.4,8.8-7.5,15.1-7.5c6.2,0,11.3,3.9,14.4,7.3c0.1,0.1,0.1,0.1,0.2,0.2l55.1,55.1 C420.456,377.706,420.456,388.206,410.256,398.806z">
                                                </path>
                                                <path
                                                    d="M256.056,112.706c26.2,4.4,50,16.8,69,35.8s31.3,42.8,35.8,69c1.1,6.6,6.8,11.2,13.3,11.2c0.8,0,1.5-0.1,2.3-0.2 c7.4-1.2,12.3-8.2,11.1-15.6c-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3,3.7-15.6,11 S248.656,111.506,256.056,112.706z">
                                                </path>
                                                <path
                                                    d="M473.256,209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2,3.7-15.5,11 c-1.2,7.4,3.7,14.3,11.1,15.6c46.6,7.9,89.1,30,122.9,63.7c33.8,33.8,55.8,76.3,63.7,122.9c1.1,6.6,6.8,11.2,13.3,11.2 c0.8,0,1.5-0.1,2.3-0.2C469.556,223.306,474.556,216.306,473.256,209.006z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </svg></strong> : {{ $newPhone ? $newPhone : 'Not provided' }}
                            @if (Auth::id() == $user->id)
                                <button class="ml-2 text-blue-500 hover:underline"
                                    wire:click="toggleEdit('phone')">Edit</button>
                            @endif
                        </p>
                        @if ($editingPhone)
                            <div class="mt-4">
                                <form wire:submit.prevent="updatePhone">
                                    <input type="text" wire:model="newPhone"
                                        class="p-2 bg-gray-700 text-gray-100 rounded">
                                    <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded">Save</button>
                                </form>
                            </div>
                        @endif
                        <p class="text-gray-300 flex items-center mt-4">
                            <svg class="mr-3 mt-1" fill="#FFFFFF" height="18px" width="18px" version="1.1"
                                id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 483.3 483.3"
                                xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path
                                                d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1 v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5 c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z">
                                            </path>
                                            <path
                                                d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3 c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95 c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4 c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg> : {{ $user->email }}
                        </p>
                    </div>
                </div>

            </div>
            <div class="mt-8 text-gray-300">
                <h3 class="text-2xl font-semibold text-gray-100 mb-4">About Me</h3>
                <p id="about-me-text">{{ $newAboutMe ? $newAboutMe : 'No description provided' }}</p>
                @if (Auth::id() == $user->id)
                    <button class="mt-2 text-blue-500 hover:underline" wire:click="toggleEdit('about_me')">Edit</button>
                @endif
                @if ($editingAbout)
                    <div id="edit-about" class=" mt-4">
                        <form wire:submit.prevent="updateAboutMe">
                            <textarea wire:model="newAboutMe" rows="4" class="p-2 bg-gray-700 text-gray-100 rounded w-full"></textarea>
                            <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded">Save</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @if (Auth::id() == $userId)
        <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl profile:mx-8">
            <div class="flex justify-center profile:justify-start">
                <button
                    class="w-full bg-black/35  hover:bg-black/40 text-white font-semibold py-4 rounded-lg text-lg flex items-center justify-center space-x-2 transition duration-300"
                    onclick="category_modal.showModal()">
                    <div class="w-[60px] h-[60px]">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12.75 8C12.75 7.58579 12.4142 7.25 12 7.25C11.5858 7.25 11.25 7.58579 11.25 8H12.75ZM11.25 16C11.25 16.4142 11.5858 16.75 12 16.75C12.4142 16.75 12.75 16.4142 12.75 16H11.25ZM8 11.25C7.58579 11.25 7.25 11.5858 7.25 12C7.25 12.4142 7.58579 12.75 8 12.75V11.25ZM16 12.75C16.4142 12.75 16.75 12.4142 16.75 12C16.75 11.5858 16.4142 11.25 16 11.25V12.75ZM11.25 8V16H12.75V8H11.25ZM8 12.75H16V11.25H8V12.75ZM20.25 12C20.25 16.5563 16.5563 20.25 12 20.25V21.75C17.3848 21.75 21.75 17.3848 21.75 12H20.25ZM12 20.25C7.44365 20.25 3.75 16.5563 3.75 12H2.25C2.25 17.3848 6.61522 21.75 12 21.75V20.25ZM3.75 12C3.75 7.44365 7.44365 3.75 12 3.75V2.25C6.61522 2.25 2.25 6.61522 2.25 12H3.75ZM12 3.75C16.5563 3.75 20.25 7.44365 20.25 12H21.75C21.75 6.61522 17.3848 2.25 12 2.25V3.75Z"
                                    fill="#374151"></path>
                            </g>
                        </svg>
                    </div>
                    <span style="color: #647180">Adaugă o categorie</span>
                </button>
            </div>
        </div>
        <div class="mt-8 bg-red-800 rounded-lg shadow-lg w-full max-w-4xl profile:mx-8">
            <div class="flex justify-center profile:justify-start">
                <button
                    class="w-full bg-black/35  hover:bg-black/40 text-white font-semibold py-4 rounded-lg text-lg flex items-center justify-center space-x-2 transition duration-300"
                    onclick="delete_category_modal.showModal()">
                    <div class="w-[60px] h-[60px]">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#323232" stroke-width="2"></path> <path d="M9 12H15" stroke="#323232" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </div>
                    <span style="color: #647180"> &nbsp; Sterge o categorie</span>
                </button>
            </div>
        </div>
        @endif
        @foreach ($categories as $category)
            <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl profile:mx-8 collapse collapse-arrow">
                
                <input type="checkbox" />
                <div class="collapse-title text-xl font-medium">
                    {{ $category->name }}
                </div>
                <div class="collapse-content">
                    {{-- another 2 accordions, Videos and Documents --}}
                    <div class="collapse collapse-arrow">
                        <input type="checkbox" />
                        <div class="collapse-title text-lg font-medium">
                            Videos
                        </div>
                        <div class="collapse-content">
                            <p>Content for Videos</p>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow">
                        <input type="checkbox" />
                        <div class="collapse-title text-lg font-medium">
                            Documents
                        </div>
                        <div class="collapse-content">
                            <p>Content for Documents</p>
                        </div>
                    </div>
            </div>
    </div>
    @endforeach


</div>
<div class="flex w-full profile:[width:unset] flex-col md:flex-row profile:flex-col">
    <div
        class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-t-lg p-8  md:max-w-xs w-full profile:mx-8 flex-1 md:mt-0 profile:mt-4">
        <h3 class="text-2xl font-semibold text-gray-100">{{ $user->role == 'Student' ? 'La ce' : 'Ce' }} materii
            vreau sa {{ $user->role == 'student' || $user->role == 'admin' ? 'invat' : 'predau' }}</h3>
        <ul class="list-disc list-inside mt-4 text-gray-300">
            @foreach ($materii as $materie)
                <li>
                    {{ $materie->possibleAnswer->answer }}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bg-gray-800 text-gray-100 shadow-lg  p-8 md:max-w-xs w-full profile:mx-8 flex-1 md:mt-0 profile:mt-4">
        <h3 class="text-2xl font-semibold text-gray-100">Nivelul de invatamant</h3>
        <ul class="list-disc list-inside mt-4 text-gray-300">
            @foreach ($nivel as $nv)
                <li>
                    {{ $nv->possibleAnswer->answer }}
                </li>
            @endforeach
        </ul>
    </div>
    <div
        class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-b-lg p-8 md:max-w-xs w-full profile:mx-8 flex-1 md:mt-0 profile:mt-4">
        <h3 class="text-2xl font-semibold text-gray-100">Stilul de
            {{ $user->role == 'student' || $user->role == 'admin' ? 'invatare' : 'predare' }} preferat</h3>
        <ul class="list-disc list-inside mt-4 text-gray-300">
            @foreach ($stil_invatare as $si)
                <li>
                    {{ $si->possibleAnswer->answer }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
<dialog id="category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box">
        <h2 class="modal-title text-2xl mb-3">Adaugă o categorie</h2>
        <hr class="my-3 border-t-1 border-gray-200 opacity-30">
        <x-form wire:submit.prevent="addCategory">
            <x-input label="Category" type="text" wire:model="newCategory" />
            <x-slot:actions>
                <x-button onclick="category_modal.close()" label="Cancel" />
                <x-button label="Adauga" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</dialog>

<dialog id="delete_category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box">
        <h2 class="modal-title text-2xl mb-3">Sterge o categorie</h2>
        <hr class="my-3 border-t-1 border-gray-200 opacity-30">
        <x-form wire:submit.prevent="deleteCategory">
            <x-input label="Category" type="text" wire:model="categoryToDelete" placeholder="Scrie numele exact al categoriei" />
            <x-slot:actions>
                <x-button onclick="delete_category_modal.close()" label="Cancel" />
                <x-button label="Sterge" class="btn-primary" type="submit" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</dialog>

</div>
@script
    <script>
        $wire.on('triggerFileUpload', (event) => {
            document.getElementById('photo-upload').click();
        });

        $wire.on('closeAddCategoryModal', (event) => {
            document.getElementById('category_modal').close();
        });

        $wire.on('closeDeleteCategoryModal', (event) => {
            document.getElementById('delete_category_modal').close();
        });
    </script>
@endscript
