<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskFeedbackController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
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

    Route::get('/tasks/{task}/feedback/create',
        [TaskFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/tasks/{task}/feedback',
        [TaskFeedbackController::class, 'store'])->name('feedback.store');

});
