<?php

namespace Juampi92\APIResources\Exceptions;

use Exception;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Lang;

class APIDeprecatedException extends Exception
{
    /**
     * Create a new exception instance that contains the deprecated message,
     * and the HTTP_MOVED_PERMANENTLY (301) code.
     */
    public function __construct()
    {
        parent::__construct(
            message: Lang::get('errors.api.deprecated'),
            code: IlluminateResponse::HTTP_MOVED_PERMANENTLY
        );
    }
}
