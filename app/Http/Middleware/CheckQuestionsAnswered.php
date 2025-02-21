<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        $userModel = new User();
        $answers = $userModel->getDifferentQuestionsAnswersCount($user);
        if ($answers == 4) {
            return true;
        }
        return false;
    }
}
