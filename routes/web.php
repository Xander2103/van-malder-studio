<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// =============================================================================
// Legacy Dutch routes (no locale prefix) — kept for backwards compatibility.
// Canonical versions live under /nl/...
// =============================================================================
Route::redirect('/', '/nl', 301)->name('home');
Route::get('/diensten', [PageController::class, 'services'])->name('services');
Route::get('/projecten', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/werkwijze', [PageController::class, 'process'])->name('process');
Route::get('/prijzen', [PageController::class, 'pricing'])->name('pricing');
Route::get('/over-mij', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [InquiryController::class, 'store'])->name('inquiries.store')->middleware('throttle:5,1');
Route::get('/privacyverklaring', [PageController::class, 'privacy'])->name('privacy');
Route::get('/showcase', [PageController::class, 'showcase'])->name('showcase');
Route::get('/studio-intro', [PageController::class, 'studioIntro'])->name('studio.intro');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots.txt');

// =============================================================================
// Locale-prefixed routes — /nl/..., /fr/..., /en/...
// SetLocale middleware sets app()->getLocale() for views.
// FR/EN pages are noindex until translations_ready in config/studio.php.
// =============================================================================
$localeRoutes = config('localized-routes');

foreach (['nl', 'fr', 'en', 'de'] as $locale) {
    $paths = $localeRoutes[$locale];

    Route::prefix($locale)
        ->middleware(['setlocale:' . $locale])
        ->group(function () use ($locale, $paths) {

            Route::get('/', [PageController::class, 'home'])->name($locale . '.home');
            Route::get($paths['services'], [PageController::class, 'services'])->name($locale . '.services');
            Route::get($paths['process'], [PageController::class, 'process'])->name($locale . '.process');
            Route::get($paths['pricing'], [PageController::class, 'pricing'])->name($locale . '.pricing');
            Route::get($paths['about'], [PageController::class, 'about'])->name($locale . '.about');
            Route::get($paths['showcase'], [PageController::class, 'showcase'])->name($locale . '.showcase');
            Route::get($paths['privacy'], [PageController::class, 'privacy'])->name($locale . '.privacy');

            // Contact — GET + POST
            Route::get($paths['contact'], [PageController::class, 'contact'])->name($locale . '.contact');
            Route::post($paths['contact'], [InquiryController::class, 'store'])
                ->name($locale . '.inquiries.store')
                ->middleware('throttle:5,1');

            // Landing pages — catch-all, must come LAST in this group
            Route::get('{slug}', [LandingPageController::class, 'show'])
                ->name($locale . '.landing')
                ->where('slug', '[a-z0-9][a-z0-9-]*');
        });
}
