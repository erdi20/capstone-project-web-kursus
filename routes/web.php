<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EssayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/course', function () {
        return view('student.course');
    });
    Route::get('/listkursus', [CourseController::class, 'index'])->name('listkursus');
    Route::get('/detailkursus/{slug}', [CourseController::class, 'show'])->name('detailkursus');

    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');

    Route::get('/payment/checkout', [PaymentController::class, 'showCheckoutPage'])->name('payment.checkout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/kelas', [ClassController::class, 'showClasses'])->name('student.kelas');
    Route::view('/quiz', 'student.quiz.quiz');
    Route::view('/hasilQuiz', 'student.quiz.hasilQuiz');

    Route::get('/essay', [EssayController::class, 'index']);
});

require __DIR__ . '/auth.php';