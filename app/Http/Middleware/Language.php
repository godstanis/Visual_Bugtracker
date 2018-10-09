<?php

namespace App\Http\Middleware;

use Closure;

use Carbon\Carbon;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestedLocale = $request->cookie('applocale');
        $applocale = config('app.locale'); // default locale

        if($request->hasCookie('applocale')) {
            if (array_key_exists($requestedLocale, config('languages'))) {
                $applocale = $requestedLocale;
            }
        }

        app()->setLocale($applocale);
        session()->put('applocale', $applocale);
        Carbon::setLocale($applocale);

        dd($requestedLocale);

        return $next($request);
    }
}
