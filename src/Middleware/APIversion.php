<?php

namespace Juampi92\APIResources\Middleware;

use Closure;
use Illuminate\Http\Request;
use Juampi92\APIResources\Facades\APIResource;

class APIversion
{
    /**
     * Handle an incoming request by setting
     * the request's api's current version.
     *
     * @param Request $request
     * @param  Closure  $next
     * @param string $apiVersion
     * @param string|null $apiName = null
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $apiVersion, ?string $apiName = null)
    {
        APIResource::setVersion($apiVersion, $apiName);
        return $next($request);
    }
}
