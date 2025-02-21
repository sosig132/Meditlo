<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Answers
{

    protected $fillable = ['answer', 'question_number'];

    public function getPossibleAnswersForAll(){
        return DB::table('possible_answers')->get();
    }

    public function addAnswer($answer, $questionNumber){

        Log::info('Answer added: ', ['answer' => $answer, 'question_number' => $questionNumber]);

        DB::table('possible_answers')->insert([
            'answer' => $answer,
            'question_number' => $questionNumber,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }

    public function addUserAnswers($answers, $userId){

        foreach ($answers as $answer){
            DB::table('answers')->insert([
                'user_id' => $userId,
                'answer_id' => $answer,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function getUserAnswersForQuestion($userId, $questionNumber){
        return DB::table('answers')
            ->join('possible_answers', 'answers.answer_id', '=', 'possible_answers.id')
            ->where('user_id', $userId)
            ->where('question_number', $questionNumber)
            ->get();
    }

    public function getAnswerByAnswerId($answerId){
        return DB::table('possible_answers')->where('id', $answerId)->first();
    }

    public function getTutorAnswerId() {
        return DB::table('possible_answers')->where('answer', 'Tutore')->first()->id;
    }

    public function getStudentAnswerId() {
        return DB::table('possible_answers')->where('answer', 'Student')->first()->id;
    }
}

