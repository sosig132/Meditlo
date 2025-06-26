<div>
    <div class="p-5 flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Tutors</h2>
            <button 
                class="btn btn-primary" 
                onclick="edit_answers_modal.showModal()">
                Edit Answers
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tutors as $tutor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $tutor->id }}">{{ $tutor->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Upcoming Sessions</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($upcomingSessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $session->tutor->id }}">{{ $session->tutor->name }}</a></td>
                            <td>{{ $session->start_time->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Past Sessions</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pastSessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $session->tutor->id }}">{{ $session->tutor->name }}</a></td>
                            <td>{{ $session->start_time->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Answers Modal -->
    <dialog id="edit_answers_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
            <button onclick="edit_answers_modal.close()" class="absolute top-0 right-0 p-2 text-gray-400 hover:text-gray-200 btn btn-ghost">
                <span class="text-2xl">&times;</span>
            </button>
            <livewire:edit-answers />
        </div>
    </dialog>
</div>
