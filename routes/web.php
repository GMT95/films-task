<?php

use App\Http\Controllers\AuthController as WebAuthController;
use App\Models\Genre;
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

Route::get('/', function () {
    return redirect()->route('films.list.page');
});

/* Web Auth Routes */
Route::get('/login', [WebAuthController::class, 'getLoginPage'])->name('login.page');
Route::get('/register', [WebAuthController::class, 'getRegisterPage'])->name('register.page');
Route::get('/logout', [WebAuthController::class, 'webLogout'])->name('logout.web');

/* Below routes are not authenticated, user must be logged in only for adding comments */
Route::view('/films', 'films.list')->name('films.list.page');
Route::get('/films/create', function() {
    $genres = Genre::query()->select('id', 'name')->get();

    return view('films.create', compact('genres'));
})->name('films.create.page');
Route::view('/films/{slug}', 'films.view')->name('films.view.page');

