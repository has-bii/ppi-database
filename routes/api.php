<?php

use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\UniversitasTurkiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\KotaTurkiController;
use App\Http\Controllers\API\PpiController;
use App\Http\Controllers\API\NewStudentController;

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
        Route::get('users', [UserController::class, 'fetchUsers'])->name('fetchUsers');
        Route::post('update-users', [UserController::class, 'updateUser'])->name('updateUser');
        Route::delete('delete', [UserController::class, 'deleteUsers'])->name('deleteUsers');
    });
});


Route::prefix('student')->middleware('auth:sanctum')->name('student')->group(function () {
    Route::get('', [StudentController::class, 'fetch'])->name('fetch');
    Route::get('fetch_count', [StudentController::class, 'fetch_students_count'])->name('fetch_students_count');
    Route::get('fetch_students', [StudentController::class, 'fetch_students'])->name('fetch_students');
    Route::post('update', [StudentController::class, 'update'])->name('update');
    Route::post('update-students', [StudentController::class, 'updateStudents'])->name('updateStudents');
    Route::get('statistic', [StudentController::class, 'fetch_statistic'])->name('fetch_statistic');
});

Route::prefix('kotaturki')->middleware('auth:sanctum')->name('kotaturki')->group(function () {
    Route::get('', [KotaTurkiController::class, 'fetch'])->name('fetch');
    Route::post('add', [KotaTurkiController::class, 'add'])->name('add');
});

Route::prefix('ppi')->middleware('auth:sanctum')->name('ppi')->group(function () {
    Route::get('', [PpiController::class, 'fetch'])->name('fetch');
    Route::post('add', [PpiController::class, 'add'])->name('add');
});

Route::prefix('universitasturki')->middleware('auth:sanctum')->name('universitasturki')->group(function () {
    Route::get('', [UniversitasTurkiController::class, 'fetch'])->name('fetch');
    Route::post('add', [UniversitasTurkiController::class, 'add'])->name('add');
});

Route::prefix('jurusan')->middleware('auth:sanctum')->name('jurusan')->group(function () {
    Route::get('', [JurusanController::class, 'fetch'])->name('fetch');
    Route::post('add', [JurusanController::class, 'add'])->name('add');
});

Route::prefix('newstudents')->middleware('auth:sanctum')->name('newstudents')->group(function () {
    Route::get('', [NewStudentController::class, 'fetch'])->name('fetch');
    Route::post('create', [NewStudentController::class, 'create'])->name('create');
    Route::post('update', [NewStudentController::class, 'update'])->name('update');
});
