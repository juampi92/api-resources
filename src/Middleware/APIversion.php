<?php

namespace Juampi92\APIResources\Middleware;

use Closure;
use Juampi92\APIResources\Facades\APIResource;

class APIversion
{
    /**
     * Handle an incoming request by setting
     * the request's api's current version
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @param string $api_v
     * @param string $api_name = null
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $api_v, $api_name = null)
    {
        APIResource::setVersion($api_v, $api_name);
        return $next($request);
    }
}
