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

    public function answers() {
        return $this->hasMany(Answer::class, 'user_id');
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public static function createUser($data) {
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

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function makeStudent() {
        $this->update(['role' => 'student']);
    }

    public function makeTutor() {
        $this->update(['role' => 'tutor']);
    }

    public static function findByEmail($email) {
        return self::where('email', $email)->first();
    }

    public function updatePassword($password) {
        $this->update(['password' => bcrypt($password)]);
    }
}
