<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'answers';
    protected $fillable = ['answer_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function possibleAnswer() {
        return $this->belongsTo(PossibleAnswer::class, 'answer_id');
    }

    public static function addPossibleAnswer($answer, $questionNumber) {
        Log::info('Answer added: ', ['answer' => $answer, 'question_number' => $questionNumber]);

        return PossibleAnswer::create([
            'answer' => $answer,
            'question_number' => $questionNumber,
        ]);
    }

    public static function addUserAnswers($answers, $userId) {
        $data = collect($answers)->map(fn($answer) => [
            'user_id' => $userId,
            'answer_id' => $answer,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        self::insert($data);
    }

    public static function getUserAnswersForQuestion($userId, $questionNumber) {
        return self::where('user_id', $userId)
            ->whereHas('possibleAnswer', fn($query) => $query->where('question_number', $questionNumber))
            ->with('possibleAnswer')
            ->get();
    }
}

