<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kelas_cont;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/kelas', [Kelas_cont::class, 'show'])->name('course.show');
// Route::get('/kelas/{courseId}', [Kelas_cont::class, 'show'])->name('course.show');
// Route::get('/kelas/{courseId}/materi/{session}', [Kelas_cont::class, 'material'])->name('course.material');
// // ... rute untuk Tugas akhir, Essai, Quiz
