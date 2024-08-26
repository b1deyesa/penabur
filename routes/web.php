<?php

use App\Http\Controllers\SertifikatController;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');
Route::get('/sertifikat/{number}', [SertifikatController::class, 'index'])->name('sertifikat.index');
Route::get('/sertifikat/{number}/print', [SertifikatController::class, 'print'])->name('sertifikat.print');