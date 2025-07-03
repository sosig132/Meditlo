<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PossibleAnswer extends Model
{
    use HasFactory;

    protected $table = 'possible_answers';
    protected $fillable = ['answer', 'question_number'];

    public function answers() {
        return $this->hasMany(Answer::class, 'answer_id');
    }

    public static function getAnswersGroupedByQuestionNumber() {
        return self::all()->groupBy('question_number');
    }

    public static function getPossibleAnswers() {
        return self::all();
    }

    public static function addPossibleAnswer($answer, $questionNumber) {
        Log::info('Answer added: ', ['answer' => $answer, 'question_number' => $questionNumber]);

        return self::create([
            'answer' => $answer,
            'question_number' => $questionNumber,
        ]);
    }

    public static function getPossibleAnswerById($answerId) {
        return PossibleAnswer::find($answerId);
    }

    public static function getTutorAnswerId() {
        return PossibleAnswer::where('answer', 'Tutor')->value('id');
    }

    public static function getStudentAnswerId() {
        return PossibleAnswer::where('answer', 'Student')->value('id');
    }

    public static function getPossibleAnswersForQuestion($questionNumber) {
        return self::where('question_number', $questionNumber)->get();
    }
}
