<?php

namespace Juampi92\APIResources\Middleware;

use Juampi92\APIResources\Exceptions\APIDeprecatedException;

class APIdeprecated
{
    /**
     * Deprecate all incoming requests.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return never
     * @throws APIDeprecatedException
     */
    public function handle($request, $next)
    {
        throw new APIDeprecatedException();
    }
}
