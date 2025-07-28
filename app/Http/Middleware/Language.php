<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class Language
{
    public function handle(Request $request, Closure $next): Response
    {
        $localeHeader = $request->header('Accept-Language');
        $defaultLocale = config('app.locale');
        $locale = substr($localeHeader ?? $defaultLocale, 0, 2);

        $supportedLocales = ['en', 'ar'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.fallback_locale', 'en');
        }
        App::setLocale($locale);
        return $next($request);
    }
}
