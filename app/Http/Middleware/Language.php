<?php

namespace App\Http\Middleware;

use Closure;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

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
        
        if( isset($_COOKIE['applocale']) and array_key_exists($_COOKIE['applocale'], Config::get('languages')) )
        {
            App::setLocale($_COOKIE['applocale']);
            Carbon::setLocale($_COOKIE['applocale']);

            Session::put('applocale', $_COOKIE['applocale']);
        }
        else
        {
            App::setLocale(Config::get('app.fallback_locale'));
            Carbon::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}
