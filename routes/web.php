<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EssayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact.us');
// web.php
Route::get('/listkursus', [CourseController::class, 'index'])->name('listkursus');
Route::middleware('auth')->group(function () {
    Route::get('/payment', function () {
        return view('student.payment');
    });
    // ---------------------
    Route::get('/detailkursus/{slug}', [CourseController::class, 'show'])->name('detailkursus');
    // ---------------------
    Route::get('listkelas', [CourseClassController::class, 'index'])->name('listkelas');  // [Route::get('/listkelas', [CourseClassController::class, 'index'])->name('listkelas'] )
    Route::get('kelas/{id}', [CourseClassController::class, 'show'])->name('kelas');  // [Route::get('/listkelas', [CourseClassController::class, 'index'])->name('listkelas'] )
    // ---------------------
    Route::get('/kelas/{classId}/materi/{materialId}', [MaterialController::class, 'show'])->name('materials.show');
    // --------------------- tugas essay
    Route::get('/kelas/{classId}/essay/{assignmentId}', [EssayController::class, 'show'])->name('essay.show');
    Route::post('/kelas/{classId}/essay/{assignmentId}/submit', [EssayController::class, 'submit'])->name('essay.submit');
    // ---------------------
    // Quiz
    Route::get('/kelas/{classId}/quiz/{assignmentId}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/kelas/{classId}/quiz/{assignmentId}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/kelas/{classId}/quiz/{assignmentId}/result', [QuizController::class, 'result'])
        ->name('quiz.result');
    // ---------------------
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    // ---------------------
    // Absensi
    Route::post('/kelas/{classId}/absen', [AttendanceController::class, 'store'])->name('attendance.store');

    // sertifikat
    Route::get('/kelas/{classId}/sertifikat', [CertificateController::class, 'download'])->name('certificates.download');
    // ---------------------

    // review
    Route::post('/kelas/{classId}/review', [ReviewController::class, 'store'])->name('reviews.store');
    // ---------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
