<?php

namespace Juampi92\APIResources\Exceptions;

use Illuminate\Http\Response as IlluminateResponse;

class APIDeprecatedException extends \Exception
{
    /**
     * Create a new exception instance that contains the deprecated message,
     * and the HTTP_MOVED_PERMANENTLY (301) code
     */
    public function __construct()
    {
        parent::__construct(trans('errors.api.deprecated') , IlluminateResponse::HTTP_MOVED_PERMANENTLY);
    }
}
