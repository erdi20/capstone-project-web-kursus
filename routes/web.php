<?php

use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EssayController;
use App\Http\Controllers\MaterialController;
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
    Route::get('/payment', function () {
        return view('student.payment');
    });
    // ---------------------
    Route::get('/listkursus', [CourseController::class, 'index'])->name('listkursus');
    Route::get('/detailkursus/{slug}', [CourseController::class, 'show'])->name('detailkursus');
    // ---------------------
    Route::get('listkelas', [CourseClassController::class, 'index'])->name('listkelas');  // [Route::get('/listkelas', [CourseClassController::class, 'index'])->name('listkelas'] )
    Route::get('kelas/{id}', [CourseClassController::class, 'show'])->name('kelas');  // [Route::get('/listkelas', [CourseClassController::class, 'index'])->name('listkelas'] )
    // ---------------------
    Route::get('/kelas/{classId}/materi/{materialId}', [MaterialController::class, 'show'])->name('materials.show');
    // Route::get('/detailmateri/{id}', [MaterialController::class, 'show'])->name('materi.show');
    // Route::get('/certificates/{classId}/download', [CertificateController::class, 'download'])->name('certificates.download');
    // ---------------------
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/checkout', [PaymentController::class, 'showCheckoutPage'])->name('payment.checkout');
    // ---------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/kelas', 'student.class');
    Route::view('/quiz', 'student.quiz.quiz');
    Route::view('/hasilQuiz', 'student.quiz.hasilQuiz');

    Route::get('/essay', [EssayController::class, 'index']);
});

require __DIR__ . '/auth.php';
