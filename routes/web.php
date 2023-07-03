<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserBalanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// movie
Route::get('/movie/{title}', [MovieController::class, 'getMovieDetail'])->name('movie.detail');

// ticket
Route::get('/movie/{title}/buy-ticket', [TicketController::class, 'getBuyTicketPage'])
    ->name('ticket.buy-page')->middleware('auth');
Route::post('/movie/{title}', [TicketController::class, 'BuyTicket'])
    ->name('ticket.buy')->middleware('auth');

// user
Route::get('/user/{username}', [UserController::class, 'getUserProfilePage'])
    ->name('user.profile')
    ->middleware('auth');

// balance
Route::get('/user/{username}/topup-balance', [UserBalanceController::class, 'getTopUpBalancePage'])
    ->name('balance.topup-page')->middleware('auth');
Route::put('/user', [UserBalanceController::class, 'TopUpBalance'])
    ->name('balance.topup')->middleware('auth');
