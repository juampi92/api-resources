<?php

namespace Juampi92\APIResources\Exceptions;

class ResourceNotFoundException extends \Exception
{
    public function __construct($classname, $path)
    {
        parent::__construct("The resource {$classname} was not found. Path: {$path}");
    }
}
