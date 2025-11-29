<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalFineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;



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

