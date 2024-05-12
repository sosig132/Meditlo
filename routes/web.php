<?php
# Controllers
use App\Livewire\Welcome;
use App\Livewire\Home;
use App\Livewire\Logout;
use App\Livewire\AdminDashboard;


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
Route::get('/home', Home::class);
Route::post('/logout', [Logout::class, 'logout']);
Route::get('/admin-dashboard', AdminDashboard::class);
