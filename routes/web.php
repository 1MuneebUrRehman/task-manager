<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();
Route::get('register-as-manager',
    [RegisterController::class, 'showRegistrationFormManager']);
Route::post('register/manager',
    [RegisterController::class, 'registerAsManager'])->name('register.manager');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('task', \App\Http\Controllers\TaskController::class);

    Route::get('roles', [\App\Http\Controllers\RoleController::class, 'index'])
        ->name('roles.index');
    Route::get('role/{id}/show',
        [\App\Http\Controllers\RoleController::class, 'show'])
        ->name('role.show');
    Route::put('role/{id}/update',
        [\App\Http\Controllers\RoleController::class, 'update'])
        ->name('role.update');

    Route::resource('feedback',
        \App\Http\Controllers\TaskFeedbackController::class);

});
