<div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Students</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Student</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $student->id }}">{{ $student->name }}</a></td>
                            <td>
                                <button wire:click="selectStudent({{ $student->id }})"
                                    onclick="assign_category_modal.showModal()" class="btn btn-primary">Assign
                                    category</button>
                                <button wire:click="selectStudentToRemove({{ $student->id }})"
                                    onclick="remove_user_modal.showModal()"
                                    class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <dialog id="remove_user_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
                <div class="modal-box flex flex-col">
                    <div class="mt-4">
                        <h3 class="text-center text-xl font-semibold mt-4">Are you sure you want to remove this student?
                        </h3>
                        <p class="text-center mt-2">This action cannot be undone.</p>
                        <div class="mt-4 flex flex-row gap-3 justify-center">
                            <button wire:click="confirmRemoveStudent" onclick="remove_user_modal.close()"
                                class="btn btn-primary">Yes</button>
                            <button wire:click="cancelRemoveStudent" onclick="remove_user_modal.close()"
                                class="btn btn-secondary">No</button>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>
        <div>
            <dialog id="assign_category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
                <div class="modal-box flex flex-col">
                    <button onclick="assign_category_modal.close()" wire:click="unselectStudent"
                        class="absolute top-0 right-0 p-2 text-gray-500 hover:text-gray-800 btn btn-ghost">
                        <span class="text-2xl">&times;</span>
                    </button>
                    <h3 class="text-center text-xl font-semibold mt-4">Assign Category</h3>

                    <x-form class="mt-5" wire:submit.prevent="assignCategories">
                        <div>
                            @foreach ($categories as $category)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}"
                                        class="mr-2">
                                    {{ $category->name }}
                                </label>
                                <br>
                            @endforeach
                        </div>
                        <x-slot:actions>
                            <x-button onclick="assign_category_modal.close()" label="Cancel" />
                            <x-button onclick="assign_category_modal.close()" label="Assign" class="btn-primary"
                                type="submit" spinner="assignCategories" />
                        </x-slot:actions>
                    </x-form>
                </div>
            </dialog>
        </div>
    </div>
    <h2 class="p-5 text-2xl">Content</h2>
    <div class="p-5 pl-10 flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Videos</h2>
            <button onclick="add_video_modal.showModal()" class="btn btn-success">Add Video</button>
        </div>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- make a button span all rows --}}

                    @foreach ($videos as $video)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $video->thumbnail }}" alt="Thumbnail" class="w-16 h-16">
                            </td>
                            <td>{{ $video->name }}</td>
                            <td>{{ $video->created_at->format('d-m-Y') }}</td>
                            <td>
                                <button wire:click="selectVideo({{ $video->id }})"
                                    onclick="edit_video_modal.showModal()" class="btn btn-primary">Edit</button>
                                <button wire:click="selectVideoToAssignCategories({{ $video->id }})"
                                    onclick="assign_video_category_modal.showModal()" class="btn btn-primary">Assign
                                    categories</button>
                                <button wire:click="selectVideoToRemove({{ $video->id }})"
                                    onclick="remove_video_modal.showModal()"
                                    class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <dialog id="remove_video_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
                <div class="modal-box flex flex-col">
                    <div class="mt-4">
                        <h3 class="text-center text-xl font-semibold mt-4">Are you sure you want to remove this video?
                        </h3>
                        <p class="text-center mt-2">This action cannot be undone.</p>
                        <div class="mt-4 flex flex-row gap-3 justify-center">
                            <button wire:click="confirmRemoveContent" onclick="remove_user_modal.close()"
                                class="btn btn-primary">Yes</button>
                            <button wire:click="cancelRemoveContent" onclick="remove_user_modal.close()"
                                class="btn btn-secondary">No</button>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>
        <div x-data="{ videoSource: 'Youtube' }">
            <dialog id="add_video_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
                <div class="modal-box flex flex-col">
                    <div class="space-y-4">
                        <h3 class="text-center text-xl font-semibold mt-4">Add Video</h3>

                        <div>
                            <label class="font-medium block mb-1">Video Source</label>
                            <select x-model="videoSource" wire:model.defer="newVideoData.source"
                                class="select select-bordered w-full">
                                <option value="Youtube">Youtube</option>
                                <option value="File">File</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-medium block mb-1">Video Name</label>
                            <input type="text" wire:model.defer="newVideoData.title" class="input input-bordered w-full"
                                placeholder="Video Name" />
                        </div>
                        <!-- Youtube URL -->
                        <div x-show="videoSource === 'Youtube'">
                            <label class="font-medium block mb-1">Video URL</label>
                            <input type="url" wire:model.defer="newVideoData.video_url"
                                class="input input-bordered w-full" placeholder="https://youtube.com/..." />
                        </div>

                        <!-- File Upload -->
                        <div x-show="videoSource === 'File'">
                            <label class="font-medium block mb-1">Video File</label>
                            <input type="file" wire:model.defer="videoFile" accept="video/*"
                                class="file-input file-input-bordered w-full" />
                        </div>

                        <div x-show="videoSource === 'File'">
                            <label class="font-medium block mb-1">Thumbnail</label>
                            <input type="file" wire:model.defer="newVideoData.thumbnail" accept="image/*"
                                class="file-input file-input-bordered w-full" />
                        </div>

                        <div>
                            <label class="font-medium block mb-1">Description</label>
                            <textarea wire:model.defer="newVideoData.description" rows="3" class="textarea textarea-bordered w-full"></textarea>
                        </div>

                        <div>
                            @foreach ($categories as $category)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model="newVideoData.selectedCategories"
                                        value="{{ $category->id }}" class="mr-2">
                                    {{ $category->name }}
                                </label><br>
                            @endforeach
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <form method="dialog">
                                <button class="btn">Cancel</button>
                            </form>
                            <button wire:click="addVideo" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>


    </div>
    <div class="p-5 pl-10 flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Documents</h2>
            <button onclick="add_document_modal.showModal()" class="btn btn-success">Add Document</button>
        </div>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- make a button span all rows --}}

                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->created_at->format('d-m-Y') }}</td>
                            <td>
                                <button wire:click="selectDocument({{ $video->id }})"
                                    onclick="edit_document_modal.showModal()" class="btn btn-primary">Edit</button>
                                <button wire:click="selectDocumentToAssignCategories({{ $video->id }})"
                                    onclick="assign_document_category_modal.showModal()"
                                    class="btn btn-primary">Assign
                                    categories</button>
                                <button wire:click="selectDocumentToRemove({{ $video->id }})"
                                    onclick="remove_document_modal.showModal()"
                                    class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
