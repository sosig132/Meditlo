<div>
  <div class="p-5 flex flex-col gap-4">
    <div class="flex justify-between items-center">
      <h2 class="text-2xl font-semibold">Students</h2>

    </div>
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
          <button wire:click="selectStudent({{ $student->id }})" onclick="assign_category_modal.showModal()"
          class="btn btn-primary">Assign
          category</button>
          <button wire:click="selectStudentToRemove({{ $student->id }})" onclick="remove_user_modal.showModal()"
          class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    <div>
      <dialog id="remove_user_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <div class="mt-4">
            <h3 class="text-center text-xl font-semibold text-gray-100">Are you sure you want to remove this student?
            </h3>
            <p class="text-center mt-2 text-gray-300">This action cannot be undone.</p>
            <div class="mt-4 flex flex-row gap-3 justify-center">
              <button wire:click="confirmRemoveStudent" onclick="remove_user_modal.close()"
                class="btn btn-primary">Yes</button>
              <button wire:click="cancelRemoveStudent" onclick="remove_user_modal.close()"
                class="btn btn-ghost">No</button>
            </div>
          </div>
        </div>
      </dialog>
    </div>
    <div>
      <dialog id="assign_category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <button onclick="assign_category_modal.close()" wire:click="unselectStudent"
            class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
            <span class="text-2xl">&times;</span>
          </button>
          <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Assign Category</h3>

          <x-form class="mt-5" wire:submit.prevent="assignCategories">
            <div class="max-h-60 overflow-y-auto bg-gray-700 rounded-lg p-4">
              @foreach ($categories as $category)
          <label class="label cursor-pointer justify-start gap-2 text-gray-300">
          <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}"
            class="checkbox checkbox-primary">
          {{ $category->name }}
          </label>
        @endforeach
            </div>
            <x-slot:actions>
              <x-button onclick="assign_category_modal.close()" label="Cancel" class="btn-ghost" />
              <x-button onclick="assign_category_modal.close()" label="Assign" class="btn-primary" type="submit"
                spinner="assignCategories" />
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
          @foreach ($videos as $video)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          @if($video->source === 'local' || $video->source === 'cloud')
        <img src="{{Storage::url($video->thumbnail) }}" alt="Thumbnail" class="w-16 h-16">
      @else
        <img src="{{ $video->thumbnail }}" alt="Thumbnail" class="w-16 h-16">
      @endif
        </td>
        <td>{{ $video->title }}</td>
        <td>{{ $video->created_at->format('d-m-Y') }}</td>
        <td class="flex flex-row gap-2">
          <button wire:click="selectContent({{ $video->id }})" onclick="edit_content_modal.showModal()"
          class="btn btn-primary">Edit</button>
          <button wire:click="selectContentCategories({{ $video->id }})"
          onclick="assign_content_category_modal.showModal()" class="btn btn-primary">Assign
          categories</button>
          <button wire:click="selectContent({{ $video->id }})" onclick="remove_content_modal.showModal()"
          class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    <div>
      <dialog id="assign_content_category_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <button onclick="assign_content_category_modal.close()" wire:click="unselectContent"
            class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
            <span class="text-2xl">&times;</span>
          </button>
          <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Assign Category</h3>

          <x-form class="mt-5" wire:submit.prevent="assignContentCategories">
            <div class="max-h-60 overflow-y-auto bg-gray-700 rounded-lg p-4">
              @foreach ($categories as $category)
          <label class="label cursor-pointer justify-start gap-2 text-gray-300">
          <input type="checkbox" wire:model="selectedContentCategories" value="{{ $category->id }}"
            class="checkbox checkbox-primary">
          {{ $category->name }}
          </label>
        @endforeach
            </div>
            <x-slot:actions>
              <x-button onclick="assign_content_category_modal.close()" wire:click="unselectContent" label="Cancel"
                class="btn-ghost" />
              <x-button onclick="assign_content_category_modal.close()" label="Assign" class="btn-primary" type="submit"
                spinner="assignCategories" />
            </x-slot:actions>
          </x-form>
        </div>
      </dialog>
    </div>
    <div>
      <dialog id="remove_content_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <div class="mt-4">
            <h3 class="text-center text-xl font-semibold text-gray-100">Are you sure you want to remove this video?</h3>
            <p class="text-center mt-2 text-gray-300">This action cannot be undone.</p>
            <div class="mt-4 flex flex-row gap-3 justify-center">
              <button wire:click="confirmRemoveContent" onclick="remove_content_modal.close()"
                class="btn btn-primary">Yes</button>
              <button wire:click="cancelRemoveContent" onclick="remove_content_modal.close()"
                class="btn btn-ghost">No</button>
            </div>
          </div>
        </div>
      </dialog>
    </div>
    <div>
      <dialog id="edit_content_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <button onclick="edit_content_modal.close()" wire:click="cancelRemoveContent"
            class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
            <span class="text-2xl">&times;</span>
          </button>
          <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Edit Video</h3>

          <x-form class="mt-5" wire:submit.prevent="updateContent">
            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Video Name</span>
              </label>
              <input type="text" wire:model.defer="editedVideoData.title"
                class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Video Name" />
            </div>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Description</span>
              </label>
              <textarea wire:model.defer="editedVideoData.description" rows="3"
                class="textarea textarea-bordered w-full bg-gray-700 text-gray-100"></textarea>
            </div>

            <x-slot:actions>
              <x-button onclick="edit_content_modal.close()" wire:click="cancelRemoveContent" label="Cancel"
                class="btn-ghost" />
              <x-button onclick="edit_content_modal.close()" label="Update" class="btn-primary" type="submit"
                spinner="updateContent" />
            </x-slot:actions>
          </x-form>
        </div>
      </dialog>
    </div>
    <div x-data="{ videoSource: 'youtube' }">
      <dialog id="add_video_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <div class="space-y-4">
            <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Add Video</h3>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Video Source</span>
              </label>
              <select x-model="videoSource" wire:model.defer="newVideoData.source"
                class="select select-bordered w-full bg-gray-700 text-gray-100">
                <option value="youtube">Youtube</option>
                <option value="File">File</option>
              </select>
            </div>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Video Name</span>
              </label>
              <input type="text" wire:model.defer="newVideoData.title"
                class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Video Name" />
            </div>

            <!-- Youtube URL -->
            <div x-show="videoSource === 'youtube'" class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Video URL</span>
              </label>
              <input type="text" wire:model.defer="newVideoData.video_url"
                class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="https://youtube.com/..." />
            </div>

            <!-- File Upload -->
            <div x-show="videoSource === 'File'" class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Video File</span>
              </label>
              <input type="file" wire:model.defer="videoFile" accept="video/*"
                class="file-input file-input-bordered w-full bg-gray-700 text-gray-100" />
            </div>

            <div x-show="videoSource === 'File'" class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Thumbnail</span>
              </label>
              <input type="file" wire:model.defer="newVideoData.thumbnail" accept="image/*"
                class="file-input file-input-bordered w-full bg-gray-700 text-gray-100" />
            </div>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Description</span>
              </label>
              <textarea wire:model.defer="newVideoData.description" rows="3"
                class="textarea textarea-bordered w-full bg-gray-700 text-gray-100"></textarea>
            </div>

            <div class="max-h-60 overflow-y-auto bg-gray-700 rounded-lg p-4 mb-4">
              @foreach ($categories as $category)
          <label class="label cursor-pointer justify-start gap-2 text-gray-300">
          <input type="checkbox" wire:model="newVideoData.selectedCategories" value="{{ $category->id }}"
            class="checkbox checkbox-primary">
          {{ $category->name }}
          </label>
        @endforeach
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button class="btn btn-ghost" onclick="add_video_modal.close()">Cancel</button>
              <button wire:click="addVideo" onclick="add_video_modal.close()" class="btn btn-primary">Save</button>
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
            <th>Type</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {{-- make a button span all rows --}}

          @foreach ($documents as $document)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $document->title }}</td>
        <td>{{ $document->file_type }}</td>
        <td>{{ $document->created_at->format('d-m-Y') }}</td>
        <td class="flex flex-row gap-2">
          <button wire:click="selectContent({{ $document->id }})" onclick="edit_document_modal.showModal()"
          class="btn btn-primary">Edit</button>
          <button wire:click="selectContentCategories({{ $document->id }})"
          onclick="assign_content_category_modal.showModal()" class="btn btn-primary">Assign
          categories</button>
          <button wire:click="selectContent({{ $document->id }})" onclick="remove_content_modal.showModal()"
          class="btn bg-red-700 hover:bg-red-800 text-white">Remove</button>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    <div>
      <dialog id="add_document_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <div class="space-y-4">
            <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Add Document</h3>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Document Name</span>
              </label>
              <input type="text" wire:model.defer="newDocumentData.title"
                class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Document Name" />
            </div>


            <!-- File Upload -->
            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Document File</span>
              </label>
              <input type="file" wire:model.defer="documentFile" accept=".pdf,.doc,.docx"
                class="file-input file-input-bordered w-full bg-gray-700 text-gray-100" />
            </div>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Description</span>
              </label>
              <textarea wire:model.defer="newDocumentData.description" rows="3"
                class="textarea textarea-bordered w-full bg-gray-700 text-gray-100"></textarea>
            </div>

            <div class="max-h-60 overflow-y-auto bg-gray-700 rounded-lg p-4 mb-4">
              @foreach ($categories as $category)
          <label class="label cursor-pointer justify-start gap-2 text-gray-300">
          <input type="checkbox" wire:model="newDocumentData.selectedCategories" value="{{ $category->id }}"
            class="checkbox checkbox-primary">
          {{ $category->name }}
          </label>
        @endforeach
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button class="btn btn-ghost" onclick="add_document_modal.close()">Cancel</button>
              <button wire:click="addDocument" onclick="add_document_modal.close()"
                class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </dialog>
    </div>
    <div>
      <dialog id="edit_document_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
          <button onclick="edit_document_modal.close()" wire:click="cancelRemoveContent"
            class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
            <span class="text-2xl">&times;</span>
          </button>
          <h3 class="text-center text-xl font-semibold text-gray-100 mt-4">Edit Document</h3>

          <x-form class="mt-5" wire:submit.prevent="updateDocument">
            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Document Name</span>
              </label>
              <input type="text" wire:model.defer="editedDocumentData.title"
                class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Document Name" />
            </div>

            <div class="form-control w-full mb-4">
              <label class="label">
                <span class="label-text text-gray-300">Description</span>
              </label>
              <textarea wire:model.defer="editedDocumentData.description" rows="3"
                class="textarea textarea-bordered w-full bg-gray-700 text-gray-100"></textarea>
            </div>

            <x-slot:actions>
              <x-button onclick="edit_document_modal.close()" wire:click="cancelRemoveContent" label="Cancel"
                class="btn-ghost" />
              <x-button onclick="edit_document_modal.close()" label="Update" class="btn-primary" type="submit"
                spinner="updateDocument" />
            </x-slot:actions>
          </x-form>
        </div>
      </dialog>
    </div>
  </div>
  <div class="p-5 flex flex-col gap-4">
    <button class="btn btn-primary" onclick="edit_answers_modal.showModal()">
      Edit Answers
    </button>
  </div>  
  <!-- Edit Answers Modal -->
  <dialog id="edit_answers_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
    <div class="modal-box bg-gray-800 text-gray-100">
      <button onclick="edit_answers_modal.close()"
        class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
        <span class="text-2xl">&times;</span>
      </button>
      <livewire:edit-answers />
    </div>
  </dialog>
</div>