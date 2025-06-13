<?php
# Controllers
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\EmailVerificationController;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Dashboards\TutorDashboard;
use App\Livewire\Dashboards\StudentDashboard;
use App\Livewire\Dashboards\AdminDashboard;
use App\Livewire\Welcome;
use App\Livewire\Home;
use App\Livewire\AnswerQuestions;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

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
// GET ROUTES (PAGES)
Route::get('/', Welcome::class)->name('unauthenticated');
Route::get('/home', Home::class)->name('home')->middleware('check.questions');
Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
Route::get('/answer-questions', AnswerQuestions::class)->name('answer-questions');
Route::get('/profile/{id}', Profile::class)->name('profile')->middleware('check.questions');
Route::get('/reset-password/{token}', ResetPassword::class)->name('reset-password');
Route::get('/confirm/{token}', [EmailVerificationController::class, 'verify'])->name('email.verify');
Route::get('/tutor-dashboard', TutorDashboard::class)->name('tutor-dashboard')->middleware('check.questions');
Route::get('/student-dashboard', StudentDashboard::class)->name('student-dashboard')->middleware('check.questions');

// POST ROUTES (ACTIONS)
Route::post('/logout', [Logout::class, 'logout'])->name('logout');