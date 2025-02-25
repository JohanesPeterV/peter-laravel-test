<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('/ping', fn () => 'pong!');


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {

    return \App\Models\User::with('role')->find(Auth::id());
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/users')->group(function () {
        Route::get('', [UserController::class, 'all']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::put('/{user}', [UserController::class, 'update']);
    })->middleware(IsAdmin::class);
});
