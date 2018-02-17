<?php

namespace Juampi92\APIResources\Middleware;

use Juampi92\APIResources\Exceptions\APIDeprecatedException;

class APIdeprecated
{
    /**
     * Deprecate all incoming requests.
     *
     * @return mixed
     * @throws APIDeprecatedException
     */
    public function handle()
    {
        throw new APIDeprecatedException();
    }
}
