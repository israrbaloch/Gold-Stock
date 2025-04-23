<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $language = 'en';
        if ($request->has('lang')) {
            $language = $request->lang;
            // Save language in cookie (1-year expiration)
            Cookie::queue('user_language', $language, 60 * 24 * 365);
        }
        // Share language globally so it can be used anywhere in views or controllers
        view()->share('language', $language);
        return $next($request);
    }
}
