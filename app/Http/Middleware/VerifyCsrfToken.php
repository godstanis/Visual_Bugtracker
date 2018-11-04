<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, \Closure $next)
    {
        // We will enable csrf verification only for non-testing requests.
        if ('testing' !== env('APP_ENV'))
        {
            return parent::handle($request, $next);
        }

        return $next($request);
    }
}
