<?php
# Controllers
use App\Livewire\Welcome;
use App\Livewire\Home;
use App\Livewire\Logout;
use App\Livewire\AdminDashboard;
use App\Livewire\AnswerQuestions;

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

Route::get('/', Welcome::class);
Route::get('/home', Home::class)->name('home')->middleware('check.questions');
Route::post('/logout', [Logout::class, 'logout']);
Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard');
Route::get('/answer-questions', AnswerQuestions::class)->name('answer-questions');
