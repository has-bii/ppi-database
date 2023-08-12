<?php

use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\AppStatusController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\FormStatusController;
use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\UniversitasTurkiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\KotaTurkiController;
use App\Http\Controllers\API\LinkController;
use App\Http\Controllers\API\MyMenuController;
use App\Http\Controllers\API\PpiController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserApplicationController;
use App\Http\Controllers\API\UserInfoController;

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

Route::prefix('user-info')->middleware('auth:sanctum')->name('user-info')->group(function () {
    Route::get('', [UserInfoController::class, 'fetch'])->name('fetch');
    Route::post('create', [UserInfoController::class, 'create'])->name('create');
    Route::post('update', [UserInfoController::class, 'update'])->name('update');
});

Route::prefix('form')->middleware('auth:sanctum')->name('form')->group(function () {
    Route::get('', [FormController::class, 'fetch'])->name('fetch');
    Route::post('create', [FormController::class, 'create'])->name('create');
    Route::post('update', [FormController::class, 'update'])->name('update');
    Route::delete('delete', [FormController::class, 'delete'])->name('delete');
});

Route::prefix('form-status')->middleware('auth:sanctum')->name('form-status')->group(function () {
    Route::get('', [FormStatusController::class, 'fetch'])->name('fetch');
    Route::post('create', [FormStatusController::class, 'create'])->name('create');
    Route::post('update', [FormStatusController::class, 'update'])->name('update');
    Route::delete('delete', [FormStatusController::class, 'delete'])->name('delete');
});

Route::prefix('answer')->middleware('auth:sanctum')->name('answer')->group(function () {
    Route::post('create', [FormStatusController::class, 'create'])->name('create');
    Route::post('update', [FormStatusController::class, 'update'])->name('update');
    Route::delete('delete', [FormStatusController::class, 'delete'])->name('delete');
});

Route::prefix('question')->middleware('auth:sanctum')->name('question')->group(function () {
    Route::post('create', [FormStatusController::class, 'create'])->name('create');
    Route::post('update', [FormStatusController::class, 'update'])->name('update');
    Route::delete('delete', [FormStatusController::class, 'delete'])->name('delete');
});

Route::prefix('my-menu')->middleware('auth:sanctum')->name('my-menu')->group(function () {
    Route::get('', [MyMenuController::class, 'fetch'])->name('fetch');
    Route::post('create', [MyMenuController::class, 'create'])->name('create');
    Route::post('update', [MyMenuController::class, 'update'])->name('update');
    Route::delete('delete', [MyMenuController::class, 'delete'])->name('delete');
});

Route::prefix('link')->middleware('auth:sanctum')->name('link')->group(function () {
    Route::get('', [LinkController::class, 'fetch'])->name('fetch');
    Route::post('create', [LinkController::class, 'create'])->name('create');
    Route::post('update', [LinkController::class, 'update'])->name('update');
    Route::delete('delete', [LinkController::class, 'delete'])->name('delete');
});

Route::prefix('application')->middleware('auth:sanctum')->name('application')->group(function () {
    Route::get('', [ApplicationController::class, 'fetch'])->name('fetch');
    Route::post('create', [ApplicationController::class, 'create'])->name('create');
    Route::post('update', [ApplicationController::class, 'update'])->name('update');
    Route::delete('delete', [ApplicationController::class, 'delete'])->name('delete');
});

Route::prefix('user-app')->middleware('auth:sanctum')->name('user-app')->group(function () {
    Route::get('', [UserApplicationController::class, 'fetch'])->name('fetch');
    Route::post('create', [UserApplicationController::class, 'create'])->name('create');
    Route::post('update', [UserApplicationController::class, 'update'])->name('update');
    Route::delete('delete', [UserApplicationController::class, 'delete'])->name('delete');
});

Route::prefix('app-status')->middleware('auth:sanctum')->name('app-status')->group(function () {
    Route::get('', [AppStatusController::class, 'fetch'])->name('fetch');
    Route::post('create', [AppStatusController::class, 'create'])->name('create');
    Route::post('update', [AppStatusController::class, 'update'])->name('update');
    Route::delete('delete', [AppStatusController::class, 'delete'])->name('delete');
});

Route::prefix('role')->middleware('auth:sanctum')->name('role')->group(function () {
    Route::get('', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('create', [RoleController::class, 'create'])->name('create');
    Route::post('update', [RoleController::class, 'update'])->name('update');
    Route::delete('delete', [RoleController::class, 'delete'])->name('delete');
});
