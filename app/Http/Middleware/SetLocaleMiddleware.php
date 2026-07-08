<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (!$locale && $request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
            $request->session()->put('locale', $locale);
        }

        if ($locale && in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            \Carbon\Carbon::setLocale($locale);
        }

        return $next($request);
    }
}
