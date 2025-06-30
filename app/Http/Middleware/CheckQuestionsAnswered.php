<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckQuestionsAnswered
{
    public function handle($request, Closure $next)
    {
        $currentUser = auth()->user();

        if ($currentUser && !$this->checkQuestions($currentUser)) {
            return redirect()->route('answer-questions');
        }
        return $next($request);
    }

    private function checkQuestions($user)
    {
        $user = User::find(Auth::user()->id);
        $answers = $user->getDifferentQuestionsAnswersCount();
        return $answers === 4;
    }
}
