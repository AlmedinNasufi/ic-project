<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

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
Route::controller(AuthController::class)->middleware(['api'])->prefix('auth')->group(function () {
    Route::post('/login','login')->name('login');
    Route::post('/register','register')->name('register');;
    Route::post('/logout','logout');
    Route::post('/refresh','refresh');
    Route::get('/user-profile','userProfile');
    Route::put('/change-password','changePassword');
});

Route::controller(RoleController::class)->middleware(['token.refresh'])->prefix('role')->group(function () {
    Route::get("/", 'index')->name("role");
    Route::post("/store", 'store')->name("role.store")->middleware(['IsAdmin']);
    Route::get("/{id}", 'show')->name("role.show");
    Route::put("/update/{id}", 'update')->name("role.update")->middleware(['IsAdmin']);
    Route::delete("/delete/{id}", 'destroy')->name("role.delete")->middleware(['IsAdmin']);
});
