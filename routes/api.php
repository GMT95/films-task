<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FilmsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("register", [AuthController::class, "register"])->name("register");
Route::post("login", [AuthController::class, "login"])->name("login");

Route::group([
    'prefix' => 'v1'
], function () {
    Route::apiResource("films", FilmsController::class);
    Route::middleware('auth:sanctum')
        ->post("films/{film}/add-comment", [FilmsController::class, "addComment"]);
});
