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
        // create a log file in the storage/logs directory
        // log the answer and question number

        Log::info('Answer added: ', ['answer' => $answer, 'question_number' => $questionNumber]);



        DB::table('possible_answers')->insert([
            'answer' => $answer,
            'question_number' => $questionNumber,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}

