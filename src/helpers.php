<?php

use Juampi92\APIResources\APIResource;
use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;

if (!function_exists('api_resource')) {
    /**
     * Returns a resource resolver.
     *
     * @param class-string $classname
     */
    function api_resource(string $classname): APIResource
    {
        return APIResourceFacade::resolve($classname);
    }
}

if (!function_exists('api_route')) {
    /**
     * Generate the URL to a versioned named route.
     *
     * @param mixed $parameters
     */
    function api_route(string $name, $parameters = [], bool $absolute = true): string
    {
        return APIResourceFacade::getRoute($name, $parameters, $absolute);
    }
}
