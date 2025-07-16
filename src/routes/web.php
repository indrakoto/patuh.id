<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;

use App\Models\Document;
use App\Models\News;

Route::get('/', function () {
    //$latestDocuments = Document::latest()->take(4)->get(); 
    $latestNews = News::latest()->take(4)->get();  
    return view('welcome', compact('latestNews'));
});

//Route::get('/news', function () {
//    //$latestDocuments = Document::latest()->take(4)->get(); 
//    $latestNews = News::latest()->take(4)->get();  
//    return view('welcome', compact('latestNews'));
//});

Route::prefix('news')->group(function() {
    // Display all knowledge
    Route::get('/', [NewsController::class, 'index'])
        ->name('news.index');

    Route::get('/search', [NewsController::class, 'search'])
        ->name('news.search');
    
    // Tampilkan halaman search (GET)
    Route::get('/search', [NewsController::class, 'showSearchPage'])
        ->name('news.search');
    
    // Proses pencarian (POST)
    Route::post('/search', [NewsController::class, 'handleSearch'])
        ->name('news.search.post');

    // Display knowledge by Institusi
    Route::get('/{institusi_slug}', [NewsController::class, 'byInstitusi'])
        ->name('news.institusi');
    
    // Display knowledge by Category
    Route::get('/kategori/{category_slug}', [NewsController::class, 'byCategory'])
        ->name('news.category');
    
    // Display a single knowledge
    Route::get('/read/{news_slug}/{id}', [NewsController::class, 'showArticle'])
        ->name('news.show');
    
    // Display knowledge by Tag
    Route::get('/tags/{tag_name}', [NewsController::class, 'byTag'])
        ->name('news.tag');
 
});




Route::get('/document/{fileName}', DocumentController::class)
    ->middleware('auth')
    ->name('document.view');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/registrasi', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');


/*Route::prefix('peraturan')->group(function () {
    Route::get('/', [PeraturanController::class, 'index'])->name('peraturan.index');
    
    Route::get('/kategori/{slug}/{id_kategori}', [PeraturanController::class, 'byKategori'])
         ->name('peraturan.kategori');
    
    Route::get('/search', [PeraturanController::class, 'search'])->name('peraturan.search');

    Route::middleware(['auth'])->group(function () {
        Route::get('/baca/{slug}/{id_peraturan}', [PeraturanController::class, 'show'])
             ->name('peraturan.show');
    });

    Route::get('/download/{slug}/{id}', [PeraturanController::class, 'download'])
        ->name('peraturan.download');

    Route::get('/peraturan/download-token/{token}', [PeraturanController::class, 'downloadByToken'])
        ->middleware('auth')
        ->name('peraturan.download.token');

});*/
// 🔓 Route Publik (Tidak Perlu Login)
Route::prefix('peraturan')->group(function () {
    Route::get('/', [PeraturanController::class, 'index'])->name('peraturan.index');
    Route::get('/kategori/{slug}/{id_kategori}', [PeraturanController::class, 'byKategori'])->name('peraturan.kategori');
    Route::get('/search', [PeraturanController::class, 'search'])->name('peraturan.search');
});

// 🔐 Route Terproteksi (Hanya untuk User Login)
Route::middleware(['auth'])->prefix('peraturan')->group(function () {
    // Baca dokumen menggunakan token terenkripsi (lebih aman)
    Route::get('/baca-token/{token}', [PeraturanController::class, 'showByToken'])->name('peraturan.show.token');

    // Download dokumen via ID langsung (opsional, bisa di-nonaktifkan)
    Route::get('/download/{slug}/{id}', [PeraturanController::class, 'download'])->name('peraturan.download');

    // Download via token terenkripsi (disarankan)
    Route::get('/download-token/{token}', [PeraturanController::class, 'downloadByToken'])->name('peraturan.download.token');
});

// Layanan Routes
Route::prefix('layanan')->group(function () {
    // Halaman utama layanan
    Route::get('/', [LayananController::class, 'index'])->name('layanan.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/membership/index', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/membership/plans', [MembershipController::class, 'plans'])->name('membership.plans');
    Route::post('/membership/purchase/{planId}', [MembershipController::class, 'purchase'])->name('membership.purchase');
    
    // Payment routes
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
});

// Midtrans webhook
Route::post('/payment/notification', [PaymentController::class, 'handleNotification']);

Route::get('/midtrans-config', function() {
    return response()->json([
        'server_key' => config('services.midtrans.server_key'),
        'client_key' => config('services.midtrans.client_key'),
        'is_production' => config('services.midtrans.is_production')
    ]);
});