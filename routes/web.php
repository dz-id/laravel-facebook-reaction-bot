<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, ReactionsController};
use App\Http\Controllers\Auth\LoginController;

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


Route::post("/login", [LoginController::class, "login"])
    ->name("login");
Route::post("/logout", [LoginController::class, "logout"])
    ->name("logout");

Route::get("/", [HomeController::class, "index"])
    ->name("home");
Route::get("/activity", [HomeController::class, "activity"])
    ->name("activity");

Route::prefix("reactions")->name("reactions.")->group(function() {
    Route::get("/", [ReactionsController::class, "index"]);
    Route::post("post", [ReactionsController::class, "post"])
        ->name("post");
    Route::post("disable", [ReactionsController::class, "disable"])
        ->name("disable");
    Route::post("enable", [ReactionsController::class, "enable"])
        ->name("enable");
});