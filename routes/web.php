<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalFineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GlobalFineController as AdminGlobalFineController;
use App\Http\Controllers\Admin\ScrapedFineController;



// Public routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/index', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/alerts', function() { return view('alerts'); });
Route::get('/dashboards', [DashboardController::class, 'index']);
Route::get('/database', [FineController::class, 'index']);
Route::get('/fines/{id}', [FineController::class, 'show'])->name('fine.show');

// Static legal pages
Route::view('/privacy', 'privacy');
Route::view('/terms', 'terms');
Route::view('/cookies', 'cookies');

// Newsletter subscription routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::post('/newsletter/preferences/{token}', [NewsletterController::class, 'updatePreferences'])->name('newsletter.preferences');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication routes (not protected)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Email verification (signed links)
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->name('verification.verify')
        ->middleware('signed');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->name('verification.send')
        ->middleware('throttle:6,1');

    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Global Fines CRUD
        Route::resource('fines', AdminGlobalFineController::class);

        // Scraped Fines management and review
        Route::resource('scraped-fines', ScrapedFineController::class);
        Route::get('scraped-fines/{scraped_fine}/review', [ScrapedFineController::class, 'review'])->name('scraped-fines.review');
        Route::post('scraped-fines/{scraped_fine}/review', [ScrapedFineController::class, 'storeReview'])->name('scraped-fines.store-review');
    });
});

