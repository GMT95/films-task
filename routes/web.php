<?php

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

Route::middleware('guest')->group(function() {
    Route::view('/login', 'login')->name('login.page');

    Route::view('/register', 'register')->name('register.page');
});

/* Below routes are not authenticated, user must be logged in only for adding comments */
Route::view('/films', 'films.list')->name('films.list.page');
Route::get('/films/create', function() {
    $genres = Genre::query()->select('id', 'name')->get();

    return view('films.create', compact('genres'));
})->name('films.create.page');
Route::view('/films/{slug}', 'films.view')->name('films.view.page');

