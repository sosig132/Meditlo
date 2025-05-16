<?php
# Controllers
use App\Livewire\TutorDashboard;
use App\Livewire\Welcome;
use App\Livewire\Home;
use App\Livewire\Logout;
use App\Livewire\AdminDashboard;
use App\Livewire\AnswerQuestions;
use App\Livewire\Profile;
use App\Livewire\ForgotPassword;
use App\Livewire\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Welcome::class)->name('unauthenticated');
Route::get('/home', Home::class)->name('home')->middleware('check.questions');
Route::post('/logout', [Logout::class, 'logout'])->name('logout');
Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
Route::get('/answer-questions', AnswerQuestions::class)->name('answer-questions');
Route::get('/profile/{id}', Profile::class)->name('profile')->middleware('check.questions');
Route::get('/reset-password/{token}', ResetPassword::class)->name('reset-password');
Route::get('/tutor-dashboard', TutorDashboard::class)->name('tutor-dashboard');
Route::post('/match-requests/{receiverId}', [MatchRequestController::class, 'create'])
    ->name('match-request.create');