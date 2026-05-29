<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const ALLOWED = ['nl', 'fr', 'en', 'de'];

    public function handle(Request $request, Closure $next, string $locale = 'nl'): Response
    {
        $locale = in_array($locale, self::ALLOWED, true) ? $locale : 'nl';
        app()->setLocale($locale);

        return $next($request);
    }
}
