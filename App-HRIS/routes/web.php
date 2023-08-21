<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/admins/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::post('/admins/loginProcess', [AdminController::class, 'loginProcess'])->name('loginProcess');
Route::get('/admins/logoutProcess', [AdminController::class, 'logoutProcess'])->name('logoutProcess');


