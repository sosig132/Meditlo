<?php

namespace App\Livewire;

use App\Models\TutorSession;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TutorCalendar extends Component
{
    use LivewireAlert;

    public $tutorId;
    public $isTutor = false;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailsModal = false;
    public $selectedSession = null;
    public $sessions = [];
    
    // Form properties
    public $title = '';
    public $description = '';
    public $start_time = '';
    public $end_time = '';
    public $type = 'one_on_one';
    public $max_students = 1;
    public $price = null;
    public $is_recurring = false;
    public $recurrence_pattern = null;
    public $recurrence_end_date = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date|after:now',
        'end_time' => 'required|date|after:start_time',
        'type' => 'required|in:one_on_one,group',
        'max_students' => 'required_if:type,group|nullable|integer|min:2',
        'price' => 'nullable|numeric|min:0',
        'is_recurring' => 'boolean',
        'recurrence_pattern' => 'required_if:is_recurring,true|nullable|in:weekly,biweekly,monthly',
        'recurrence_end_date' => 'required_if:is_recurring,true|nullable|date|after:start_time',
    ];

    public function mount($tutorId = null)
    {
        $this->tutorId = $tutorId ?? auth()->id();
        $this->isTutor = auth()->id() === (int) $this->tutorId;
        $this->loadSessions();
    }

    public function loadSessions()
    {
        $tutor = \App\Models\User::find($this->tutorId);
        if (!$tutor) {
            return;
        }

        $sessions = $tutor->tutorSessions()
            ->with(['participants' => function ($query) {
                $query->where('status', 'registered');
            }])
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'start' => $session->start_time->format('Y-m-d\TH:i:s'),
                    'end' => $session->end_time->format('Y-m-d\TH:i:s'),
                    'type' => $session->type,
                    'max_students' => $session->max_students,
                    'available_spots' => $session->getAvailableSpots(),
                    'price' => $session->price,
                    'description' => $session->description,
                    'is_recurring' => $session->is_recurring,
                    'recurrence_pattern' => $session->recurrence_pattern,
                    'recurrence_end_date' => $session->recurrence_end_date?->format('Y-m-d'),
                    'backgroundColor' => $session->type === 'group' ? '#4CAF50' : '#2196F3',
                    'borderColor' => $session->type === 'group' ? '#388E3C' : '#1976D2',
                    'extendedProps' => [
                        'type' => $session->type,
                        'available_spots' => $session->getAvailableSpots(),
                        'registered_count' => $session->participants->count(),
                    ],
                ];
            });

        $this->sessions = $sessions;
    }

    public function openCreateModal()
    {
        if (!$this->isTutor) {
            return;
        }
        $this->resetForm();
        $this->showCreateModal = true;
        $this->dispatch('showCreateModal');
    }

    public function openEditModal($sessionId)
    {
        if (!$this->isTutor) {
            return;
        }
        $session = TutorSession::find($sessionId);
        if (!$session || $session->tutor_id !== auth()->id()) {
            return;
        }

        $this->selectedSession = $session;
        $this->title = $session->title;
        $this->description = $session->description;
        $this->start_time = $session->start_time->format('Y-m-d\TH:i');
        $this->end_time = $session->end_time->format('Y-m-d\TH:i');
        $this->type = $session->type;
        $this->max_students = $session->max_students;
        $this->price = $session->price;
        $this->is_recurring = $session->is_recurring;
        $this->recurrence_pattern = $session->recurrence_pattern;
        $this->recurrence_end_date = $session->recurrence_end_date?->format('Y-m-d');

        $this->showEditModal = true;
        $this->dispatch('showEditModal');
    }

    public function openDetailsModal($sessionId)
    {
        $session = TutorSession::with(['participants.student'])
            ->find($sessionId);
        
        if (!$session) {
            return;
        }

        $this->selectedSession = $session;
        $this->showDetailsModal = true;
        $this->dispatch('showDetailsModal');
    }

    public function createSession()
    {
        if (!$this->isTutor) {
            return;
        }

        $this->validate();

        $session = TutorSession::create([
            'tutor_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'max_students' => $this->type === 'group' ? $this->max_students : null,
            'price' => $this->price,
            'is_recurring' => $this->is_recurring,
            'recurrence_pattern' => $this->is_recurring ? $this->recurrence_pattern : null,
            'recurrence_end_date' => $this->is_recurring ? $this->recurrence_end_date : null,
        ]);

        if ($this->is_recurring) {
            $this->createRecurringSessions($session);
        }

        $this->showCreateModal = false;
        $this->resetForm();
        $this->loadSessions();
        $this->alert('success', 'Session created successfully!');
    }

    public function updateSession()
    {
        if (!$this->isTutor || !$this->selectedSession) {
            return;
        }

        $this->validate();

        $this->selectedSession->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type,
            'max_students' => $this->type === 'group' ? $this->max_students : null,
            'price' => $this->price,
            'is_recurring' => $this->is_recurring,
            'recurrence_pattern' => $this->is_recurring ? $this->recurrence_pattern : null,
            'recurrence_end_date' => $this->is_recurring ? $this->recurrence_end_date : null,
        ]);

        $this->showEditModal = false;
        $this->resetForm();
        $this->loadSessions();
        $this->alert('success', 'Session updated successfully!');
    }

    public function deleteSession($sessionId)
    {
        if (!$this->isTutor) {
            return;
        }

        $session = TutorSession::find($sessionId);
        if (!$session || $session->tutor_id !== auth()->id()) {
            return;
        }

        $session->delete();
        $this->loadSessions();
        $this->alert('success', 'Session deleted successfully!');
    }

    public function registerForSession($sessionId)
    {
        if (auth()->user()->role !== 'student') {
            $this->alert('error', 'Only students can register for sessions.');
            return;
        }

        $session = TutorSession::find($sessionId);
        if (!$session) {
            $this->alert('error', 'Session not found.');
            return;
        }

        // Check if session is full
        if (!$session->canAcceptMoreStudents()) {
            $this->alert('error', 'This session is full.');
            return;
        }

        try {
            // Check if student has a cancelled registration
            $existingParticipant = $session->participants()
                ->where('student_id', auth()->id())
                ->first();

            if ($existingParticipant) {
                if ($existingParticipant->status === 'registered') {
                    $this->alert('error', 'You are already registered for this session.');
                    return;
                } elseif ($existingParticipant->status === 'cancelled') {
                    // Re-register by updating the status
                    $existingParticipant->update(['status' => 'registered']);
                    $this->loadSessions();
                    $this->alert('success', 'Successfully re-registered for the session!');
                    return;
                }
            }

            // Create new registration
            $session->participants()->create([
                'student_id' => auth()->id(),
                'status' => 'registered',
            ]);

            $this->loadSessions();
            $this->alert('success', 'Successfully registered for the session!');
        } catch (\Exception $e) {
            $this->alert('error', 'An error occurred while registering for the session.');
            \Log::error('Session registration error: ' . $e->getMessage());
        }
    }

    public function cancelRegistration($sessionId)
    {
        if (auth()->user()->role !== 'student') {
            return;
        }

        $session = TutorSession::find($sessionId);
        if (!$session) {
            return;
        }

        if ($session->cancelStudentRegistration(auth()->id())) {
            $this->loadSessions();
            $this->alert('success', 'Successfully cancelled your registration!');
        } else {
            $this->alert('error', 'Could not cancel your registration.');
        }
    }

    private function createRecurringSessions(TutorSession $baseSession)
    {
        $start = Carbon::parse($baseSession->start_time);
        $end = Carbon::parse($baseSession->end_time);
        $duration = $end->diffInMinutes($start);
        $recurrenceEnd = Carbon::parse($this->recurrence_end_date);

        while ($start->copy()->add($this->getRecurrenceInterval()) <= $recurrenceEnd) {
            $start->add($this->getRecurrenceInterval());
            $newEnd = $start->copy()->addMinutes($duration);

            TutorSession::create([
                'tutor_id' => $baseSession->tutor_id,
                'title' => $baseSession->title,
                'description' => $baseSession->description,
                'start_time' => $start->format('Y-m-d H:i:s'),
                'end_time' => $newEnd->format('Y-m-d H:i:s'),
                'type' => $baseSession->type,
                'max_students' => $baseSession->max_students,
                'price' => $baseSession->price,
                'is_recurring' => true,
                'recurrence_pattern' => $baseSession->recurrence_pattern,
                'recurrence_end_date' => $baseSession->recurrence_end_date,
            ]);
        }
    }

    private function getRecurrenceInterval()
    {
        return match($this->recurrence_pattern) {
            'weekly' => \Carbon\CarbonInterval::week(),
            'biweekly' => \Carbon\CarbonInterval::weeks(2),
            'monthly' => \Carbon\CarbonInterval::month(),
            default => \Carbon\CarbonInterval::week(),
        };
    }

    private function resetForm()
    {
        $this->reset([
            'title', 'description', 'start_time', 'end_time',
            'type', 'max_students', 'price', 'is_recurring',
            'recurrence_pattern', 'recurrence_end_date', 'selectedSession'
        ]);
    }

    public function render()
    {
        return view('livewire.tutor-calendar');
    }
} 