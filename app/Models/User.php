<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getUserAnswers($user){
        $userAnswers = DB::table('answers')->where('user_id', $user->id)->get();
        return $userAnswers;
    }

    public function getDifferentQuestionsAnswersCount($user){

        $userAnswers = DB::table('answers')->join('possible_answers', 'answers.answer_id', '=', 'possible_answers.id')->where('user_id', $user->id)->get();
        $userAnswersUnique = $userAnswers->unique('question_number');
        return $userAnswersUnique->count();
    }

    public function getIsUserAdmin($user){
        $isAdmin = DB::table('users')->where('id', $user->id)->where('Role', 'admin')->get();
        return $isAdmin;
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }
}
