<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TutorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'type',
        'max_students',
        'price',
        'status',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_end_date',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'recurrence_end_date' => 'date',
        'is_recurring' => 'boolean',
        'max_students' => 'integer',
        'price' => 'decimal:2',
    ];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(SessionParticipant::class, 'session_id');
    }

    public function registeredStudents(): HasMany
    {
        return $this->hasMany(SessionParticipant::class, 'session_id')
            ->where('status', 'registered');
    }

    public function isGroupSession(): bool
    {
        return $this->type === 'group';
    }

    public function isOneOnOne(): bool
    {
        return $this->type === 'one_on_one';
    }

    public function isFull(): bool
    {
        if ($this->isOneOnOne()) {
            return $this->registeredStudents()->count() >= 1;
        }
        return $this->registeredStudents()->count() >= $this->max_students;
    }

    public function canAcceptMoreStudents(): bool
    {
        if ($this->isOneOnOne()) {
            return $this->registeredStudents()->count() === 0;
        }
        return $this->registeredStudents()->count() < $this->max_students;
    }

    public function getAvailableSpots(): int
    {
        if ($this->isOneOnOne()) {
            return $this->registeredStudents()->count() === 0 ? 1 : 0;
        }
        return max(0, $this->max_students - $this->registeredStudents()->count());
    }

    public function isStudentRegistered(int $studentId): bool
    {
        return $this->participants()
            ->where('student_id', $studentId)
            ->where('status', 'registered')
            ->exists();
    }

    public function registerStudent(int $studentId, ?string $notes = null): bool
    {
        if (!$this->canAcceptMoreStudents()) {
            return false;
        }

        if ($this->isStudentRegistered($studentId)) {
            return false;
        }

        // Check if student is associated with tutor
        if (!$this->tutor->students()->where('student_id', $studentId)->exists()) {
            return false;
        }

        $this->participants()->create([
            'student_id' => $studentId,
            'status' => 'registered',
            'notes' => $notes,
        ]);

        return true;
    }

    public function cancelStudentRegistration(int $studentId): bool
    {
        $participant = $this->participants()
            ->where('student_id', $studentId)
            ->where('status', 'registered')
            ->first();

        if (!$participant) {
            return false;
        }

        $participant->update(['status' => 'cancelled']);
        return true;
    }
} 