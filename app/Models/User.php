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

  public function ratingsReceived()
  {
    return $this->hasMany(TutorRating::class, 'tutor_id');
  }

  public function ratingsGiven()
  {
    return $this->hasMany(TutorRating::class, 'student_id');
  }

  public function getGivenRatingByUser($studentId)
  {
    $rating = $this->ratingsReceived()
      ->where('student_id', $studentId)
      ->first();
    return $rating ?: null;
  }

  public function getAverageRating()
  {
    $ratings = $this->ratingsReceived()->pluck('rating');
    if ($ratings->isEmpty()) {
      return 0;
    }
    return $ratings->avg();
  }

  public function getRatingCount()
  {
    return $this->ratingsReceived()->count();
  }

  public function rateTutor($tutorId, $rating, $comment = null)
  {
    if ($this->role !== 'student') {
      throw new \Exception("Only students can rate tutors.");
    }

    $existingRating = $this->ratingsGiven()
      ->where('tutor_id', $tutorId)
      ->first();

    if ($existingRating) {
      $existingRating->update(['rating' => $rating, 'comment' => $comment]);
    } else {
      TutorRating::create([
        'tutor_id' => $tutorId,
        'student_id' => $this->id,
        'rating' => $rating,
        'comment' => $comment,
      ]);
    }
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
    $this->ownedCategories()->where('user_id', $studentId)->delete();
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

  public function messages()
  {
    return $this->hasMany(Message::class);
  }

  public function conversations()
  {
    return $this->hasMany(Conversation::class, 'user_one_id')
      ->orWhere('user_two_id', $this->id);
  }

  public function getAllUserConversations()
  {
    return $this->conversations()
      ->with([
        'messages' => function ($query) {
          $query->orderBy('created_at', 'desc');
        }
      ])
      ->get();
  }
  public function getUnreadMessagesCount()
  {
    return $this->messages()->where('read', false)->count();
  }

  public function getConversationUnreadMessagesCount($conversationId)
  {
    return $this->messages()
      ->where('conversation_id', $conversationId)
      ->where('read', false)
      ->count();
  }

  public function userHasOwnedCategory($categoryName)
  {
    if (!$this->ownedCategories()->exists()) {
      return false;
    }
    if (!$this->ownedCategories()->where('name', $categoryName)->exists()) {
      return false;
    }
    $categoryId = Categories::where('name', $categoryName)->first()->id;
    return $this->ownedCategories()->where('id', $categoryId)->exists();
  }
  public function getCategoryId($categoryName)
  {
    return $this->categories()->where('name', $categoryName)->first()->id;
  }

  public function getOwnedCategoryId($categoryName)
  {
    return $this->ownedCategories()->where('name', $categoryName)->first()->id;
  }
  public function ownedCategories()
  {
    return $this->hasMany(Categories::class, 'user_id');
  }

  public function categories()
  {
    return $this->belongsToMany(Categories::class, 'category_user', 'user_id', 'category_id');
  }
  public function getCategories()
  {
    return $this->categories()->get();
  }
  public function getOwnedCategories()
  {
    return $this->ownedCategories()->get();
  }
  public static function getStudentCategories($studentId)
  {
    $student = self::find($studentId);
    if (!$student) {
      throw new \Exception("Student not found.");
    }
    return $student->categories()->get();
  }

  public static function getNonAdminUsers()
  {
    return self::where('role', '!=', 'admin')->get();
  }

  public static function assignCategoriesToStudent($categories, $studentId)
  {
    $student = self::find($studentId);
    if (!$student) {
      throw new \Exception("Student not found.");
    }
    $student->categories()->sync($categories);
  }
  public static function getStudentCategoriesForTutor($studentId, $tutorId)
  {
    $student = self::find($studentId);
    if (!$student) {
      throw new \Exception("Student not found.");
    }
    return $student->categories()->where('categories.user_id', $tutorId)->get();
  }

  public function getVideos()
  {
    return $this->hasMany(Content::class, 'user_id')->where('type', 'video')->get();
  }
  public function getVideosQuery()
  {
    return $this->hasMany(Content::class, 'user_id')->where('type', 'video');
  }
  public function getDocumentsQuery()
  {
    return $this->hasMany(Content::class, 'user_id')->where('type', 'document');
  }
  public function getDocuments()
  {
    return $this->hasMany(Content::class, 'user_id')->where('type', 'document')->get();
  }
  public function getVideosCount()
  {
    return $this->getVideos()->count();
  }
  public function getDocumentsCount()
  {
    return $this->getDocuments()->count();
  }
  public function getContent()
  {
    return $this->hasMany(Content::class, 'user_id')->get();
  }

  public function getContentCount()
  {
    return $this->getContent()->count();
  }

  public static function getStudentContentForTutor($tutorId, $studentId, $categories = null)
  {
    // the returned will be like this : ['category' => ['documents' => [], 'videos' => []]] for all the $categories

    $student = self::find($studentId);
    if (!$student) {
      throw new \Exception("Student not found.");
    }
    $content = [];

    if (!$categories) {
      return [];
    }
    foreach ($categories as $category) {
      $content[$category->name] = [
        'documents' => $student->getDocumentsQuery()->whereHas('categories', function ($query) use ($category, $tutorId) {
          $query->where('categories.id', $category->id);
        })->get(),
        'videos' => $student->getVideosQuery()->whereHas('categories', function ($query) use ($category, $tutorId) {
          $query->where('categories.id', $category->id);
        })->get(),
      ];
    }

    return $content;
  }

  public static function getTutorContent($tutorId)
  {
    $tutor = self::find($tutorId);
    if (!$tutor) {
      throw new \Exception("Tutor not found.");
    }
    $content = [];
    $categories = $tutor->getOwnedCategories();
    foreach ($categories as $category) {
      $content[$category->name] = [
        'documents' => $tutor->getDocumentsQuery()->whereHas('categories', function ($query) use ($category) {
          $query->where('categories.id', $category->id);
        })->get(),
        'videos' => $tutor->getVideosQuery()->whereHas('categories', function ($query) use ($category) {
          $query->where('categories.id', $category->id);
        })->get(),
      ];
    }
    return $content;
  }

  public function deleteUser()
  {
    $this->delete();
  }
}
