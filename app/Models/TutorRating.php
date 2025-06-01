<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorRating extends Model
{
  use HasFactory;
  protected $fillable = [
    'tutor_id',
    'student_id',
    'rating',
    'comment',
  ];
  protected $table = 'tutor_ratings';

  public function tutor()
  {
    return $this->belongsTo(User::class, 'tutor_id');
  }

  public function student()
  {
    return $this->belongsTo(User::class, 'student_id');
  }

  public static function getAverageRating($tutorId)
  {
    $ratings = self::where('tutor_id', $tutorId)->pluck('rating');
    if ($ratings->isEmpty()) {
      return 0;
    }
    return $ratings->avg();
  }

  public static function getRatingCount($tutorId)
  {
    return self::where('tutor_id', $tutorId)->count();
  }
}
