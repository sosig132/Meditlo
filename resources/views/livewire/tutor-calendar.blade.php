<div>
    <!-- Include FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    
    <style>
        .fc-event {
            cursor: pointer;
        }
        .fc-event-title {
            font-weight: 500;
        }
        .session-type-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .session-type-one-on-one {
            background-color: #2196F3;
            color: white;
        }
        .session-type-group {
            background-color: #4CAF50;
            color: white;
        }
        #calendar {
            min-height: 600px;
        }
    </style>

    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-100">Tutoring Schedule</h2>
            @if($isTutor)
                <button wire:click="openCreateModal" class="btn btn-primary">
                    Create New Session
                </button>  
            @endif
        </div>

        <div id="calendar" class="bg-white rounded-lg p-4" wire:ignore></div>
    </div>

    <!-- Create Session Modal -->
    <dialog id="create_session_modal" class="modal" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100" x-data="{ showMaxStudents: false }">
            <h3 class="font-bold text-lg mb-4">Create New Session</h3>
            <form wire:submit.prevent="createSession">
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Title <span class="text-red-500">*</span></span>
                    </label>
                    <input type="text" wire:model.defer="title" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Session title">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Description</span>
                    </label>
                    <textarea wire:model.defer="description" class="textarea textarea-bordered w-full bg-gray-700 text-gray-100" placeholder="Session description"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">Start Time <span class="text-red-500">*</span></span>
                        </label>
                        <input type="datetime-local" wire:model.defer="start_time" class="input input-bordered bg-gray-700 text-gray-100">
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">End Time <span class="text-red-500">*</span></span>
                        </label>
                        <input type="datetime-local" wire:model.defer="end_time" class="input input-bordered bg-gray-700 text-gray-100">
                        @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Session Type <span class="text-red-500">*</span></span>
                    </label>
                    <select wire:model.defer="type" x-on:change="showMaxStudents = $event.target.value === 'group'" class="select select-bordered w-full bg-gray-700 text-gray-100">
                        <option value="one_on_one">One-on-One</option>
                        <option value="group">Group Session</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4" x-show="showMaxStudents" x-transition>
                    <label class="label">
                        <span class="label-text text-gray-300">Maximum Students <span class="text-red-500">*</span></span>
                        <span class="label-text-alt text-gray-400">(2-20 students)</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="range" wire:model.defer="max_students" min="2" max="20" class="range range-primary flex-1" />
                        <input type="number" wire:model.defer="max_students" min="2" max="20" class="input input-bordered w-24 bg-gray-700 text-gray-100 text-center" />
                    </div>
                    @error('max_students') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Price (optional)</span>
                    </label>
                    <input type="number" wire:model.defer="price" min="0" step="0.01" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Price per student">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text text-gray-300">Recurring Session</span>
                        <input type="checkbox" wire:model.defer="is_recurring" class="toggle toggle-primary">
                    </label>
                </div>

                <div x-data="{ showRecurrence: false }" x-show="$wire.is_recurring" x-transition>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300">Recurrence Pattern <span class="text-red-500">*</span></span>
                            </label>
                            <select wire:model.defer="recurrence_pattern" class="select select-bordered w-full bg-gray-700 text-gray-100">
                                <option value="">Select pattern</option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Bi-weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            @error('recurrence_pattern') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300">End Date <span class="text-red-500">*</span></span>
                            </label>
                            <input type="date" wire:model.defer="recurrence_end_date" class="input input-bordered bg-gray-700 text-gray-100">
                            @error('recurrence_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Create Session</button>
                    <button type="button" class="btn" onclick="create_session_modal.close()">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Edit Session Modal -->
    <dialog id="edit_session_modal" class="modal" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100" x-data="{ showMaxStudents: false }">
            <h3 class="font-bold text-lg mb-4">Edit Session</h3>
            <form wire:submit.prevent="updateSession">
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Title <span class="text-red-500">*</span></span>
                    </label>
                    <input type="text" wire:model.defer="title" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Session title">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Description</span>
                    </label>
                    <textarea wire:model.defer="description" class="textarea textarea-bordered w-full bg-gray-700 text-gray-100" placeholder="Session description"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">Start Time <span class="text-red-500">*</span></span>
                        </label>
                        <input type="datetime-local" wire:model.defer="start_time" class="input input-bordered bg-gray-700 text-gray-100">
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">End Time <span class="text-red-500">*</span></span>
                        </label>
                        <input type="datetime-local" wire:model.defer="end_time" class="input input-bordered bg-gray-700 text-gray-100">
                        @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Session Type <span class="text-red-500">*</span></span>
                    </label>
                    <select wire:model.defer="type" x-on:change="showMaxStudents = $event.target.value === 'group'" class="select select-bordered w-full bg-gray-700 text-gray-100">
                        <option value="one_on_one">One-on-One</option>
                        <option value="group">Group Session</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4" x-show="showMaxStudents" x-transition>
                    <label class="label">
                        <span class="label-text text-gray-300">Maximum Students <span class="text-red-500">*</span></span>
                        <span class="label-text-alt text-gray-400">(2-20 students)</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="range" wire:model.defer="max_students" min="2" max="20" class="range range-primary flex-1" />
                        <input type="number" wire:model.defer="max_students" min="2" max="20" class="input input-bordered w-24 bg-gray-700 text-gray-100 text-center" />
                    </div>
                    @error('max_students') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text text-gray-300">Price (optional)</span>
                    </label>
                    <input type="number" wire:model.defer="price" min="0" step="0.01" class="input input-bordered w-full bg-gray-700 text-gray-100" placeholder="Price per student">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label cursor-pointer">
                        <span class="label-text text-gray-300">Recurring Session</span>
                        <input type="checkbox" wire:model.defer="is_recurring" class="toggle toggle-primary">
                    </label>
                </div>

                <div x-data="{ showRecurrence: false }" x-show="$wire.is_recurring" x-transition>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300">Recurrence Pattern <span class="text-red-500">*</span></span>
                            </label>
                            <select wire:model.defer="recurrence_pattern" class="select select-bordered w-full bg-gray-700 text-gray-100">
                                <option value="">Select pattern</option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Bi-weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            @error('recurrence_pattern') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300">End Date <span class="text-red-500">*</span></span>
                            </label>
                            <input type="date" wire:model.defer="recurrence_end_date" class="input input-bordered bg-gray-700 text-gray-100">
                            @error('recurrence_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Update Session</button>
                    <button type="button" class="btn" onclick="edit_session_modal.close()">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Session Details Modal -->
    <dialog id="session_details_modal" class="modal" wire:ignore.self>
        <div class="modal-box bg-gray-800 text-gray-100">
            @if($selectedSession)
                <h3 class="font-bold text-lg mb-4">{{ $selectedSession->title }}</h3>
                
                <div class="mb-4">
                    <span class="session-type-badge session-type-{{ $selectedSession->type }}">
                        {{ $selectedSession->type === 'group' ? 'Group Session' : 'One-on-One' }}
                    </span>
                </div>

                <div class="mb-4">
                    <p class="text-gray-300">
                        <strong>Time:</strong><br>
                        {{ $selectedSession->start_time->format('F j, Y, g:i a') }} - 
                        {{ $selectedSession->end_time->format('g:i a') }}
                    </p>
                </div>

                @if($selectedSession->description)
                    <div class="mb-4">
                        <p class="text-gray-300">
                            <strong>Description:</strong><br>
                            {{ $selectedSession->description }}
                        </p>
                    </div>
                @endif

                @if($selectedSession->type === 'group')
                    <div class="mb-4">
                        <p class="text-gray-300">
                            <strong>Available Spots:</strong> {{ $selectedSession->getAvailableSpots() }} / {{ $selectedSession->max_students }}
                        </p>
                    </div>
                @endif

                @if($selectedSession->price)
                    <div class="mb-4">
                        <p class="text-gray-300">
                            <strong>Price:</strong> ${{ number_format($selectedSession->price, 2) }} per student
                        </p>
                    </div>
                @endif

                @if($selectedSession->is_recurring)
                    <div class="mb-4">
                        <p class="text-gray-300">
                            <strong>Recurring:</strong> {{ ucfirst($selectedSession->recurrence_pattern) }} until {{ $selectedSession->recurrence_end_date->format('F j, Y') }}
                        </p>
                    </div>
                @endif

                @if($isTutor)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-300 mb-2">Registered Students:</h4>
                        @if($selectedSession->participants->count() > 0)
                            <ul class="list-disc list-inside text-gray-300">
                                @foreach($selectedSession->participants as $participant)
                                    <li>{{ $participant->student->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400">No students registered yet.</p>
                        @endif
                    </div>

                    <div class="modal-action">
                        <button onclick="session_details_modal.close()" wire:click="openEditModal({{ $selectedSession->id }})" class="btn btn-primary">Edit Session</button>
                        <button wire:click="deleteSession({{ $selectedSession->id }})" class="btn btn-error">Delete Session</button>
                        <button class="btn" onclick="session_details_modal.close()">Close</button>
                    </div>
                @endif

                @if(auth()->user()->role === 'student')
                    <div class="modal-action">
                        @if($selectedSession->isStudentRegistered(auth()->id()))
                            <button wire:click="cancelRegistration({{ $selectedSession->id }})" 
                                onclick="session_details_modal.close()"
                                class="btn btn-error"
                                wire:loading.attr="disabled">
                                Cancel Registration
                            </button>
                        @else
                            <button wire:click="registerForSession({{ $selectedSession->id }})" 
                                class="btn btn-primary"
                                wire:loading.attr="disabled"
                                @if(!$selectedSession->canAcceptMoreStudents()) disabled @endif>
                                <span wire:loading.remove wire:target="registerForSession({{ $selectedSession->id }})">
                                    Register for Session
                                </span>
                                <span wire:loading wire:target="registerForSession({{ $selectedSession->id }})">
                                    Registering...
                                </span>
                            </button>
                        @endif
                        <button class="btn" onclick="session_details_modal.close()">Close</button>
                    </div>
                @elseif(!$isTutor)
                    <div class="modal-action">
                        <button class="btn" onclick="session_details_modal.close()">Close</button>
                    </div>
                @endif
            @endif
        </div>
    </dialog>

    <!-- Include FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                console.error('Calendar element not found');
                return;
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                slotDuration: '00:30:00',
                events: @json($sessions),
                eventClick: function(info) {
                    @this.openDetailsModal(info.event.id);
                },
                eventDidMount: function(info) {
                    // Add tooltip with available spots
                    const spots = info.event.extendedProps.available_spots;
                    const type = info.event.extendedProps.type;
                    const registered = info.event.extendedProps.registered_count;
                    const title = `${info.event.title}\nType: ${type === 'group' ? 'Group' : 'One-on-One'}\nAvailable spots: ${spots}\nRegistered: ${registered}`;
                    info.el.title = title;
                }
            });

            calendar.render();

            Livewire.on('sessionsUpdated', () => {
                console.log('Sessions updated');
                calendar.removeAllEvents();
                calendar.addEventSource(@json($sessions));
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            console.log('Livewire loaded');
            document.addEventListener('showCreateModal', () => {
                create_session_modal.showModal();
            });

            document.addEventListener('showEditModal', () => {
                edit_session_modal.showModal();
            });

            document.addEventListener('showDetailsModal', () => {
                session_details_modal.showModal();
            });

            // Close modals when Livewire updates
            document.addEventListener('sessionsUpdated', () => {
                create_session_modal.close();
                edit_session_modal.close();
                session_details_modal.close();
            });
        });
    </script>
</div> 