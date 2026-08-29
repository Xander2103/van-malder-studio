<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuickContactController;
use Illuminate\Support\Facades\Route;

// =============================================================================
// Legacy Dutch routes (no locale prefix) — permanently redirected to /nl/...
// so the canonical localized URL is the only indexable version of each page.
// Route names are kept so existing route('...') calls keep resolving.
// POST endpoints stay functional for old forms/bookmarks.
// =============================================================================
Route::redirect('/', '/nl', 301)->name('home');
Route::redirect('/diensten', '/nl/diensten', 301)->name('services');
Route::redirect('/projecten', '/nl/over-mij#vm-studios', 301)->name('projects.index');
Route::redirect('/werkwijze', '/nl/werkwijze', 301)->name('process');
Route::redirect('/prijzen', '/nl/prijzen', 301)->name('pricing');
Route::redirect('/over-mij', '/nl/over-mij', 301)->name('about');
Route::redirect('/contact', '/nl/contact', 301)->name('contact');
Route::post('/contact', [InquiryController::class, 'store'])->name('inquiries.store')->middleware('throttle:5,1');
Route::post('/bericht', [QuickContactController::class, 'store'])->name('quick_message.store')->middleware('throttle:quick-contact');
Route::redirect('/privacyverklaring', '/nl/privacyverklaring', 301)->name('privacy');
Route::redirect('/showcase', '/nl/showcase', 301)->name('showcase');
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

            // Contact — GET + POST (project inquiry) + quick message POST
            Route::get($paths['contact'], [PageController::class, 'contact'])->name($locale . '.contact');
            Route::post($paths['contact'], [InquiryController::class, 'store'])
                ->name($locale . '.inquiries.store')
                ->middleware('throttle:5,1');
            Route::post('bericht', [QuickContactController::class, 'store'])
                ->name($locale . '.quick_message.store')
                ->middleware('throttle:quick-contact');

            // Landing pages — catch-all, must come LAST in this group
            // ->defaults() injects $locale into the controller; the prefix is static, not a {locale} param.
            Route::get('{slug}', [LandingPageController::class, 'show'])
                ->defaults('locale', $locale)
                ->name($locale . '.landing')
                ->where('slug', '[a-z0-9][a-z0-9-]*');
        });
}
