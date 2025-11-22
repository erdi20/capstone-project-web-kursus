<?php

use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/kelas', [ClassStudentController::class, 'show'])->name('course.show');
    Route::get('/hasilQuiz', [AssignmentsController::class, 'hasilQuiz'])->name('course.hasilQuiz');
    Route::get('/esay', [AssignmentsController::class, 'essay'])->name('course.essay');
    Route::get('/quiz', [AssignmentsController::class, 'quiz'])->name('course.quiz');
    Route::POST('/submitQuiz', [AssignmentsController::class, 'submit'])->name('course.submitQuiz');
});

require __DIR__ . '/auth.php';
