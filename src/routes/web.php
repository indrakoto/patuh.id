<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

use App\Models\Document;

Route::get('/', function () {
    $latestDocuments = Document::latest()->take(4)->get();  
    return view('welcome', compact('latestDocuments'));
});


Route::get('/document/{fileName}', DocumentController::class)
    ->middleware('auth')
    ->name('document.view');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/registrasi', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');