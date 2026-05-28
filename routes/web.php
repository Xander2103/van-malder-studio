<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/diensten', [PageController::class, 'services'])->name('services');
Route::get('/projecten', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/werkwijze', [PageController::class, 'process'])->name('process');
Route::get('/prijzen', [PageController::class, 'pricing'])->name('pricing');
Route::get('/over-mij', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [InquiryController::class, 'store'])->name('inquiries.store')->middleware('throttle:5,1');
Route::get('/privacyverklaring', [PageController::class, 'privacy'])->name('privacy');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots.txt');
