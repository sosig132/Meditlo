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
                                <button wire:click="selectStudent({{ $student->id }})" onclick="assign_category_modal.showModal()" class="btn btn-primary">Assign
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
                            <button wire:click="confirmRemoveStudent" onclick="remove_user_modal.close()" class="btn btn-primary">Yes</button>
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
                                    <input type="checkbox" wire:model="selectedCategories"
                                        value="{{ $category->id }}" class="mr-2">
                                    {{ $category->name }}
                                </label>
                                <br>
                            @endforeach
                        </div>
                        <x-slot:actions>
                            <x-button onclick="assign_category_modal.close()" label="Cancel" />
                            <x-button onclick="assign_category_modal.close()" label="Assign"  class="btn-primary" type="submit" spinner="assignCategories" />
                        </x-slot:actions>
                    </x-form>
                </div>
            </dialog>
        </div>
    </div>
    <div class="p-5 flex flex-col gap-4">
      
    </div>
</div>
