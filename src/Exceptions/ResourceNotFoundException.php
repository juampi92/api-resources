<?php

namespace Juampi92\APIResources\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct(string $classname, string $path)
    {
        parent::__construct("The resource {$classname} was not found. Path: {$path}");
    }
}
