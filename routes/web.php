<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;

Route::get('/', [FileController::class, 'index'])->name('files.index');
Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::delete('file/delete/{id}', [FileController::class, 'destroy'])->name('file.delete');

Route::get('/test-email', function () {
    Mail::to('your_email@example.com')->send(new TestEmail());
    return 'Email sent successfully!';
});
