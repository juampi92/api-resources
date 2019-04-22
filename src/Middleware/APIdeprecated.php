<?php

namespace Juampi92\APIResources\Middleware;

use Juampi92\APIResources\Exceptions\APIDeprecatedException;

class APIdeprecated
{
    /**
     * Deprecate all incoming requests.
     *
     * @throws APIDeprecatedException
     *
     * @return mixed
     */
    public function handle()
    {
        throw new APIDeprecatedException();
    }
}
