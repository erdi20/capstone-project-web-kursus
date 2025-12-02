<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\EssayController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseClassController;

Route::get('/', function () {
    return view('guest');
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
    Route::get('/payment/checkout', [PaymentController::class, 'showCheckoutPage'])->name('payment.checkout');
    // ---------------------
    // Absensi
    Route::post('/kelas/{classId}/absen', [AttendanceController::class, 'store'])->name('attendance.store');
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
