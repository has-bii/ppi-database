<?php

use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\UniversitasTurkiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\KotaTurkiController;
use App\Http\Controllers\PpiController;
use App\Models\Jurusan;

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

Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::post('update', [UserController::class, 'update'])->name('update');
        Route::get('user', [UserController::class, 'fetch'])->name('fetch');
    });
});


Route::prefix('student')->middleware('auth:sanctum')->name('student')->group(function () {
    Route::get('', [StudentController::class, 'fetch'])->name('fetch');
    Route::get('fetch_count', [StudentController::class, 'fetch_students_count'])->name('fetch_students_count');
    Route::get('fetch_students', [StudentController::class, 'fetch_students'])->name('fetch_students');
    Route::post('update', [StudentController::class, 'update'])->name('update');
});

Route::prefix('kotaturki')->middleware('auth:sanctum')->name('kotaturki')->group(function () {
    Route::get('', [KotaTurkiController::class, 'fetch'])->name('fetch');
});

Route::prefix('ppi')->middleware('auth:sanctum')->name('ppi')->group(function () {
    Route::get('', [PpiController::class, 'fetch'])->name('fetch');
});

Route::prefix('universitasturki')->middleware('auth:sanctum')->name('universitasturki')->group(function () {
    Route::get('', [UniversitasTurkiController::class, 'fetch'])->name('fetch');
});

Route::prefix('jurusan')->middleware('auth:sanctum')->name('jurusan')->group(function () {
    Route::get('', [JurusanController::class, 'fetch'])->name('fetch');
});
