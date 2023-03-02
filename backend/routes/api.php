<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[UserController::class, 'register'])->name('register')->middleware(['api', 'return-json']);
Route::post('/login',[UserController::class, 'login'])->name('login')->middleware(['api', 'return-json']);

Route::middleware(['auth:api', 'api', 'return-json'])->group(function() {
     Route::get('/show',[UserController::class, 'show'])->name('show');
     Route::post('/logout',[UserController::class, 'logout'])->name('logout');

     Route::apiResource('blog',BlogController::class);
});