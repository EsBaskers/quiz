<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Main', function () {
    $subjects = \App\Models\Subject::with('questions')->get();
    return view('Main', compact('subjects'));
});
Route::get('/register', [RegisterController::class, 'create'])->middleware("guest")->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/logout',[SessionController::class, 'destroy'])->name('logout');

Route::get('/login', [SessionController::class, 'create'])->middleware("guest")->name('login');
Route::post('/login', [SessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
    Route::post('/settings', [QuizController::class, 'updateSettings'])->name('settings.update');
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{id}/results', [QuizController::class, 'storeResult'])->name('quiz.results.store');
    Route::get('/leaderboard', [QuizController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/admin', [QuizController::class, 'adminPanel'])->name('admin.panel');
    Route::post('/admin/admins', [QuizController::class, 'addAdmin'])->name('admin.admins.store');
    Route::get('/admin/questions', [QuizController::class, 'editQuestions'])->name('admin.questions');
    Route::post('/admin/questions/{id}', [QuizController::class, 'updateQuestion'])->name('admin.update-question');
});
