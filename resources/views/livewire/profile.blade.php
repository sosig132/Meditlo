<div
    class="flex flex-col profile:flex-row items-start justify-center md:space-y-4 profile:space-y-0 profile:space-x-4 sm:justify-center px-4">
    <div class="flex flex-col max-w-4xl w-full">
        <div
            class="bg-gray-800 text-gray-100 shadow-lg rounded-lg p-8 max-w-4xl w-full profile:px-8 profile:mt-4 flex-1">
            <div class="flex flex-col profile:flex-row items-center space-y-4 profile:space-y-0 profile:space-x-8">
                <div class="relative group">
                    <img src="{{ $photo ? asset('storage/' . $photo) : 'https://adaptcommunitynetwork.org/wp-content/uploads/2023/09/person-placeholder-450x330.jpg' }}"
                        id="profile-image" alt="Profile Photo"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-700 @if (Auth::id() == $user->id) cursor-pointer transition duration-300 ease-in-out transform group-hover:scale-105 @endif"
                        wire:click="triggerUpload">
                    @if (Auth::id() == $user->id)
                        <div id="overlay"
                            class="cursor-pointer absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            wire:click="triggerUpload">
                            <span class="text-white text-sm font-semibold">Change Photo</span>
                        </div>

                        <input type="file" id="photo-upload" wire:model="photo" class="hidden" accept="image/*">
                    @endif
                </div>
                <div class="text-center profile:text-left">
                    <div class="flex items-center justify-center profile:justify-start gap-2">
                        <h2 class="text-3xl font-semibold text-gray-100">{{ $user->name }}</h2>
                        @if (Auth::id() != $user->id && Auth::user()->role == 'student')
                            <livewire:tutor-rating-form :tutorId="$user->id" />
                        @endif
                    </div>
                    <p class="text-gray-300 mt-2">{{ ucfirst($user->role) }}</p>
                    <div class="mt-6">
                        <p class="text-gray-300 flex items-center">
                          <strong><svg class="mr-3" fill="#FFFFFF" height="18px" width="18px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 368.666 368.666" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_2_"> <g> <g> <path d="M184.333,0C102.01,0,35.036,66.974,35.036,149.297c0,33.969,11.132,65.96,32.193,92.515 c27.27,34.383,106.572,116.021,109.934,119.479l7.169,7.375l7.17-7.374c3.364-3.46,82.69-85.116,109.964-119.51 c21.042-26.534,32.164-58.514,32.164-92.485C333.63,66.974,266.656,0,184.333,0z M285.795,229.355 c-21.956,27.687-80.92,89.278-101.462,110.581c-20.54-21.302-79.483-82.875-101.434-110.552 c-18.228-22.984-27.863-50.677-27.863-80.087C55.036,78.002,113.038,20,184.333,20c71.294,0,129.297,58.002,129.296,129.297 C313.629,178.709,304.004,206.393,285.795,229.355z"></path> <path d="M184.333,59.265c-48.73,0-88.374,39.644-88.374,88.374c0,48.73,39.645,88.374,88.374,88.374s88.374-39.645,88.374-88.374 S233.063,59.265,184.333,59.265z M184.333,216.013c-37.702,0-68.374-30.673-68.374-68.374c0-37.702,30.673-68.374,68.374-68.374 s68.373,30.673,68.374,68.374C252.707,185.341,222.035,216.013,184.333,216.013z"></path> </g> </g> </g> </g></svg>
                          </strong> : {{ $newLocation ? $newLocation : 'Not provided' }}
                          @if (Auth::id() == $user->id)
                              <button class="ml-2 text-blue-500 hover:underline"
                                  wire:click="toggleEdit('location')">Edit</button>
                          @endif
                        </p>
                        @if ($editingLocation)
                            <div class="mt-4">
                                <form wire:submit.prevent="updateLocation">
                                    <input type="text" wire:model="newLocation"
                                        class="p-2 bg-gray-700 text-gray-100 rounded">
                                    <button type="submit" class="mt-2 bg-blue-500 text-white p-2 rounded">Save</button>
                                </form>
                            </div>
                        @endif
                        <p class="text-gray-300 flex items-center mt-4">
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
        <div class="flex lg:hidden w-full profile:[width:unset] md:flex-row flex-col">
            <div
                class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-t-lg p-8  md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
                <h3 class="text-2xl font-semibold text-gray-100">{{ $user->role == 'Student' ? 'What' : 'What' }} subjects
                    do I want to {{ $user->role == 'student' || $user->role == 'admin' ? 'learn' : 'teach' }}</h3>
                <ul class="list-disc list-inside mt-4 text-gray-300">
                    @foreach ($materii as $materie)
                        <li>
                            {{ $materie->possibleAnswer->answer }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div
                class="bg-gray-800 text-gray-100 shadow-lg  p-8 md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
                <h3 class="text-2xl font-semibold text-gray-100">Education level</h3>
                <ul class="list-disc list-inside mt-4 text-gray-300">
                    @foreach ($nivel as $nv)
                        <li>
                            {{ $nv->possibleAnswer->answer }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div
                class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-b-lg p-8 md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
                <h3 class="text-2xl font-semibold text-gray-100">Preferred
                    {{ $user->role == 'student' || $user->role == 'admin' ? 'learning' : 'teaching' }} style</h3>
                <ul class="list-disc list-inside mt-4 text-gray-300">
                    @foreach ($stil_invatare as $si)
                        <li>
                            {{ $si->possibleAnswer->answer }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if (Auth::id() == $userId && Auth::user()->role == 'tutor')
            <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl">
                <livewire:tutor-calendar :tutorId="$userId" />
            </div>
            <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl">
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
                        <span style="color: #647180">Add a category</span>
                    </button>
                </div>
            </div>
            <div class="mt-8 bg-red-800 rounded-lg shadow-lg w-full max-w-4xl">
                <div class="flex justify-center profile:justify-start">
                    <button
                        class="w-full bg-black/35  hover:bg-black/40 text-white font-semibold py-4 rounded-lg text-lg flex items-center justify-center space-x-2 transition duration-300"
                        onclick="delete_category_modal.showModal()">
                        <div class="w-[60px] h-[60px]">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                        stroke="#323232" stroke-width="2"></path>
                                    <path d="M9 12H15" stroke="#323232" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                        <span style="color: #647180"> &nbsp; Delete a category</span>
                    </button>
                </div>
            </div>
        @elseif (Auth::user()->role == 'student' && $user->role == 'tutor')
            <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl">
                <livewire:tutor-calendar :tutorId="$userId" />
            </div>
        @endif
        @foreach ($categories as $category)
            <div class="mt-8 bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl profile:px-8 collapse collapse-arrow">

                <input type="checkbox" />
                <div class="collapse-title text-xl font-medium">
                    {{ $category['name'] }}
                </div>
                <div class="collapse-content" wire:ignore.self>
                    <div class="collapse collapse-arrow">
                        <input type="checkbox" />
                        <div class="collapse-title text-lg font-medium">
                            Videos
                        </div>
                        <div class="collapse-content w-full max-w-full max-h-[100vh] min-h-[0] min-w-[0]">
                            <div class="swiper video-swiper-{{ $category['id'] }}">
                                <div class="swiper-wrapper">
                                    @foreach ($category['videos'] as $video)
                                        <div class="swiper-slide">
                                            <div class="video-card w-fit p-3 rounded btn-ghost cursor-pointer transition duration-300"
                                                id="{{ $video['id'] }}"
                                                wire:click="selectVideo('{{ $video['id'] }}')">
                                                <div class="video-thumbnail h-[150px] w-[150px] object-cover">
                                                    <img class='h-[150px] w-[150px] object-cover'
                                                        src="{{ $video['thumbnail_url'] }}"
                                                        alt="{{ $video['title'] }}">
                                                </div>
                                                <div class="w-[150px] text-center text-gray-100 mt-2 line-clamp-3">
                                                    {{ $video['title'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center gap-8 lg:justify-start justify-center">
                                    <button id="slider-button-left"
                                        class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-black/50 bg-black/70 !w-12 !h-12 transition-all duration-500 rounded-full !top-3/4 !-translate-y-8"
                                        data-carousel-prev>
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                    <button id="slider-button-right"
                                        class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-black/50 bg-black/70 !w-12 !h-12 transition-all duration-500 rounded-full !top-3/4 !-translate-y-8"
                                        data-carousel-next>
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow">
                        <input type="checkbox" />
                        <div class="collapse-title text-lg font-medium">
                            Documents
                        </div>
                        <div class="collapse-content w-full max-w-full max-h-[100vh] min-h-[0] min-w-[0]">
                            <div class="swiper doc-swiper-{{ $category['id'] }}">
                                <div class="swiper-wrapper">
                                    @foreach ($category['documents'] as $document)
                                        <div class="swiper-slide">
                                            <a class="document-card w-fit p-3 rounded btn-ghost cursor-pointer transition duration-300"
                                                id="{{ $document['id'] }}" href="{{ $document['uri'] }}" download>
                                                <div class="document-thumbnail h-[150px] w-[150px] object-cover">
                                                    @if ($document['file_type'] === 'pdf')
                                                        <svg viewBox="-4 0 40 40" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z"
                                                                    fill="#EB5757"></path>
                                                            </g>
                                                        </svg>
                                                    @else
                                                        <svg fill="#1857B8" version="1.1" id="Capa_1"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            viewBox="0 0 470.586 470.586" xml:space="preserve">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <g>
                                                                    <path
                                                                        d="M327.081,0H90.234c-15.9,0-28.854,12.959-28.854,28.859v412.863c0,15.924,12.953,28.863,28.854,28.863H380.35 c15.917,0,28.855-12.939,28.855-28.863V89.234L327.081,0z M333.891,43.184l35.996,39.121h-35.996V43.184z M384.972,441.723 c0,2.542-2.081,4.629-4.634,4.629H90.234c-2.551,0-4.62-2.087-4.62-4.629V28.859c0-2.548,2.069-4.613,4.62-4.613h219.41v70.181 c0,6.682,5.444,12.099,12.129,12.099h63.198V441.723z M131.858,161.048l-25.29-99.674h18.371l11.688,49.795 c1.646,6.954,3.23,14.005,4.592,20.516c1.555-6.682,3.425-13.774,5.272-20.723l13.122-49.583h16.863l11.969,49.929 c1.552,6.517,3.094,13.243,4.395,19.742c1.339-5.784,2.823-11.718,4.348-17.83l0.562-2.217l12.989-49.618h17.996l-28.248,99.673 h-16.834l-12.395-51.173c-1.531-6.289-2.87-12.052-3.975-17.693c-1.292,5.618-2.799,11.366-4.643,17.794l-13.964,51.072h-16.819 V161.048z M242.607,139.863h108.448c5.013,0,9.079,4.069,9.079,9.079c0,5.012-4.066,9.079-9.079,9.079H242.607 c-5.012,0-9.079-4.067-9.079-9.079C233.529,143.933,237.596,139.863,242.607,139.863z M360.135,209.566 c0,5.012-4.066,9.079-9.079,9.079H125.338c-5.012,0-9.079-4.067-9.079-9.079c0-5.013,4.066-9.079,9.079-9.079h225.718 C356.068,200.487,360.135,204.554,360.135,209.566z M360.135,263.283c0,5.012-4.066,9.079-9.079,9.079H125.338 c-5.012,0-9.079-4.067-9.079-9.079c0-5.013,4.066-9.079,9.079-9.079h225.718C356.068,254.204,360.135,258.271,360.135,263.283z M360.135,317c0,5.013-4.066,9.079-9.079,9.079H125.338c-5.012,0-9.079-4.066-9.079-9.079c0-5.012,4.066-9.079,9.079-9.079h225.718 C356.068,307.921,360.135,311.988,360.135,317z M360.135,371.474c0,5.013-4.066,9.079-9.079,9.079H125.338 c-5.012,0-9.079-4.066-9.079-9.079s4.066-9.079,9.079-9.079h225.718C356.068,362.395,360.135,366.461,360.135,371.474z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="w-[150px] text-center text-gray-100 mt-2 line-clamp-3">
                                                    {{ $document['title'] }}
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center gap-8 lg:justify-start justify-center">
                                    <button id="slider-button-left"
                                        class="swiper-button-prev group !p-2 flex justify-center items-center border border-solid border-black/50 bg-black/70 !w-12 !h-12 transition-all duration-500 rounded-full !top-3/4 !-translate-y-8"
                                        data-carousel-prev>
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                    <button id="slider-button-right"
                                        class="swiper-button-next group !p-2 flex justify-center items-center border border-solid border-black/50 bg-black/70 !w-12 !h-12 transition-all duration-500 rounded-full !top-3/4 !-translate-y-8"
                                        data-carousel-next>
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($user->role == 'tutor')
            <livewire:tutor-ratings-display :tutorId="$user->id" />
        @endif  
    </div>
    <div class="hidden lg:flex w-full profile:[width:unset] flex-col md:flex-row profile:flex-col">
        <div
            class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-t-lg p-8  md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
            <h3 class="text-2xl font-semibold text-gray-100">{{ $user->role == 'Student' ? 'What' : 'What' }} subjects
                do I want to {{ $user->role == 'student' || $user->role == 'admin' ? 'learn' : 'teach' }}</h3>
            <ul class="list-disc list-inside mt-4 text-gray-300">
                @foreach ($materii as $materie)
                    <li>
                        {{ $materie->possibleAnswer->answer }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div
            class="bg-gray-800 text-gray-100 shadow-lg  p-8 md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
            <h3 class="text-2xl font-semibold text-gray-100">Education level</h3>
            <ul class="list-disc list-inside mt-4 text-gray-300">
                @foreach ($nivel as $nv)
                    <li>
                        {{ $nv->possibleAnswer->answer }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div
            class="bg-gray-800 text-gray-100 shadow-lg profile:rounded-b-lg p-8 md:max-w-xs w-full profile:px-8 flex-1 md:mt-0 profile:mt-4">
            <h3 class="text-2xl font-semibold text-gray-100">Preferred
                {{ $user->role == 'student' || $user->role == 'admin' ? 'learning' : 'teaching' }} style</h3>
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
        <div class="modal-box bg-gray-800 text-gray-100">
            <h2 class="font-bold text-lg mb-4">Add a Category</h2>
            <x-form wire:submit.prevent="addCategory">
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Category</span>
                    </label>
                    <input type="text" wire:model="newCategory" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter category name">
                    @error('newCategory') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <x-slot:actions>
                    <x-button onclick="category_modal.close()" label="Cancel" class="btn-ghost" />
                    <x-button label="Add" class="btn-primary" type="submit" spinner="login" />
                </x-slot:actions>
            </x-form>
        </div>
    </dialog>

    <dialog id="delete_category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
            <h2 class="font-bold text-lg mb-4">Delete a Category</h2>
            <x-form wire:submit.prevent="deleteCategory">
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Category</span>
                    </label>
                    <input type="text" wire:model="categoryToDelete" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Enter the exact category name">
                    @error('categoryToDelete') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <x-slot:actions>
                    <x-button onclick="delete_category_modal.close()" label="Cancel" class="btn-ghost" />
                    <x-button label="Delete" class="btn-primary" type="submit" spinner="login" />
                </x-slot:actions>
            </x-form>
        </div>
    </dialog>
    <dialog id="video_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="w-full h-full max-w-3xl max-h-2xl content-center">
            <div class="relative flex flex-col items-center w-full p-3 rounded" style="background: #1d232a;">
                <button wire:click="unselectVideo()" class="absolute top-0 right-0 text-white"
                    style="top: -20px; z-index: 999; border: 1px solid; background: black; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <svg fill="#FFFFFF" height="20px" width="20px" version="1.1" id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 460.775 460.775" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z">
                            </path>
                        </g>
                    </svg>
                </button>
                @if ($selectedVideo)
                    @if ($selectedVideo->source == 'youtube')
                        <div id="player" class="w-full plyr__video-embed" data-plyr-provider="youtube"
                            data-plyr-embed-id="{{ $selectedVideo->yt_id }}"></div>
                    @elseif ($selectedVideo->source == 'local')
                        <video id="player" class="plyr" controls>
                            <source src="{{ $selectedVideo->uri }}" type="video/mp4" />
                        </video>
                    @else
                        <div style="aspect-ratio: 16 / 9; width: 100%; max-width: 48rem; margin: 0 auto;">
                            <iframe src="{{ $selectedVideo->uri }}" loading="lazy"
                                style="border: none; width:100%; height:100%;" allowfullscreen="true"
                                allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"></iframe>
                        </div>
                    @endif
                    <div class="ml-5 w-full">
                        <p class="text-gray-300 p-5">{{ $selectedVideo->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </dialog>
</div>

@assets
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
@endassets

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
        document.addEventListener('livewire:initialized', function() {
            swiper();
        });

        function swiper() {
            const options = {
                slidesPerView: 2,
                breakpoints: {
                    640: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 3
                    },
                    1024: {
                        slidesPerView: 4
                    },
                },
                scrollbar: {
                    el: '.swiper-scrollbar',

                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            };
            document.querySelectorAll('[class*="video-swiper-"]').forEach(el => {
                new Swiper(el, options);
            });

            document.querySelectorAll('[class*="doc-swiper-"]').forEach(el => {
                new Swiper(el, options);
            });
            console.log('Swiper initialized');
        }
        document.addEventListener('openVideoModal', function(event) {
            const videoModal = document.getElementById('video_modal');
            videoModal.showModal();
            setTimeout(() => {
                new Plyr('#player');
                swiper();
            }, 200);
        });

        document.addEventListener('closeVideoModal', function(event) {
            const videoModal = document.getElementById('video_modal');
            videoModal.close();
            const player = document.getElementById('player');
            if (player) {
                player.pause();
                player.src = '';
            }
            setTimeout(() => {
                swiper();
            }, 200);
        });
    </script>
@endscript
