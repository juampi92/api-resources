<?php

namespace Juampi92\APIResources\Middleware;

use Closure;
use Juampi92\APIResources\Facades\APIResource;

class APIversion
{
    /**
     * Handle an incoming request by setting
     * the request's api's current version.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @param string $apiVersion
     * @param string $apiName = null
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $apiVersion, $apiName = null)
    {
        APIResource::setVersion($apiVersion, $apiName);
        return $next($request);
    }
}
