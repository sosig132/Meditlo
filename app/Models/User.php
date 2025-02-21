<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function getUserWithProfile($userId){
        $userWithProfile = DB::table('users')
            ->leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->where('users.id', $userId)
            ->select(
                'users.id as id_user',
                'users.*',
                'user_profiles.*'
            )
            ->first();
        return $userWithProfile;
    }

    public function updateProfile($array){
        $data = array_filter($array, function($value) {
            return !is_null($value);
        });
        $user_id = Auth::id();
        return DB::table('user_profiles')->updateOrInsert(
            ['user_id' => $user_id],
            $data
        );
    }

    public function makeStudent($userId){
        DB::table('users')->where('id', $userId)->update(['role' => 'student']);
    }

    public function makeTutor($userId){
        DB::table('users')->where('id', $userId)->update(['role' => 'tutor']);
    }

    public function getUserByEmail($email){
        $user = DB::table('users')->where('email', $email)->first();
        return $user;
    }

    public function updatePasswordResetToken($email, $token){
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],  // Match the record by email
            ['token' => $token, 'created_at' => now()]  // The fields to update or insert
        );
    }

    public function getPasswordResetToken($email){
        $token = DB::table('password_reset_tokens')->where('email', $email)->first();
        return $token;
    }

    public function deletePasswordResetToken($email){
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    public function getUserByToken($token){
        $user = DB::table('password_reset_tokens')->where('token', $token)->first();
        return $user;
    }

    public function updatePassword($user, $password){
        DB::table('users')->where('id', $user->id)->update(['password' => bcrypt($password)]);
    }
}
