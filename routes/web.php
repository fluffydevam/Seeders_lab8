<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('students')->name('students.')->controller(StudentController::class)->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{student}/edit', 'edit')->name('edit');
    Route::put('/{student}', 'update')->name('update');
    Route::patch('/{student}', 'update');
    Route::delete('/{student}', 'destroy')->name('destroy');
});
