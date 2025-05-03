<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'tutors_students', 'tutor_id', 'student_id');
    }

    public function tutors()
    {
        return $this->belongsToMany(User::class, 'tutors_students', 'student_id', 'tutor_id');
    }

    public static function createUser($data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = self::create($data);

        $user->profile()->create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    public function getDifferentQuestionsAnswersCount()
    {
        return $this->answers()
            ->join('possible_answers', 'answers.answer_id', '=', 'possible_answers.id')
            ->select('possible_answers.question_number')
            ->distinct('possible_answers.question_number')
            ->count();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function makeStudent()
    {
        $this->update(['role' => 'student']);
    }

    public function makeTutor()
    {
        $this->update(['role' => 'tutor']);
    }

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function updatePassword($password)
    {
        $this->update(['password' => bcrypt($password)]);
    }

    public function getUsersByRole($role)
    {
        return self::where('role', $role)->get();
    }

    public function getUserById($id)
    {
        return self::find($id);
    }

    public function getUserByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function filterUsers($subjects = null, $levels = null, $styles = null, $name = null, $role = "tutor")
    {
        $query = self::query();

        $subjects = PossibleAnswer::whereIn('answer', $subjects)->pluck('id')->toArray();
        $levels = PossibleAnswer::whereIn('answer', $levels)->pluck('id')->toArray();
        $styles = PossibleAnswer::whereIn('answer', $styles)->pluck('id')->toArray();

        if ($role) {
            $query->where('role', $role);
        }

        if (empty($subjects) && empty($levels) && empty($styles) && empty($name)) {
            return $query->get();
        }

        if ($subjects) {
            $query->whereHas('answers', function ($q) use ($subjects) {
                $q->whereIn('answer_id', $subjects);
            });
        }

        if ($levels) {
            $query->whereHas('answers', function ($q) use ($levels) {
                $q->whereIn('answer_id', $levels);
            });
        }

        if ($styles) {
            $query->whereHas('answers', function ($q) use ($styles) {
                $q->whereIn('answer_id', $styles);
            });
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }



        return $query->get();
    }

    public function isTutor()
    {
        return $this->role === 'tutor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function addStudentToTutor($studentId)
    {
        if ($this->isStudent()) {
            throw new \Exception("Only tutors can add students.");
        }
        if ($this->students()->where('student_id', $studentId)->exists()) {
            throw new \Exception("Student already added.");
        }

        $this->students()->attach($studentId);
    }

    public static function addStudentToTutorStatic($tutorId, $studentId)
    {
        $tutor = self::find($tutorId);
        if (!$tutor) {
            throw new \Exception("Tutor not found.");
        }
        if ($tutor->students()->where('student_id', $studentId)->exists()) {
            return;
        }
        $tutor->students()->attach($studentId);

    }

    public function removeStudentFromTutor($studentId)
    {
        if ($this->isStudent()) {
            throw new \Exception("Only tutors can remove students.");
        }
        if (!$this->students()->where('student_id', $studentId)->exists()) {
            throw new \Exception("Student not found.");
        }
        $this->students()->detach($studentId);
    }

    public static function checkIfStudentIsInTutorList($tutorId, $studentId)
    {
        return self::where('id', $tutorId)
            ->whereHas('students', function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
            ->exists();
    }

    public function getStudents()
    {
        return $this->students()->get();
    }

    public function getTutors()
    {
        return $this->tutors()->get();
    }

    public function getStudentCount()
    {
        return $this->students()->count();
    }

    public function getTutorCount()
    {
        return $this->tutors()->count();
    }

    public function getStudentIds()
    {
        return $this->students()->pluck('id')->toArray();
    }

    public function getTutorIds()
    {
        return $this->tutors()->pluck('id')->toArray();
    }

    public function getStudentNames()
    {
        return $this->students()->pluck('name')->toArray();
    }

    public function getTutorNames()
    {
        return $this->tutors()->pluck('name')->toArray();
    }
}
