<?php

use Juampi92\APIResources\Facades\APIResource;

if (!function_exists('api_resource')) {
    /**
     * Returns a resource resolver
     *
     * @param string $classname
     *
     * @return \Juampi92\APIResources\APIResource
     */
    function api_resource($classname)
    {
        return APIResource::resolve($classname);
    }
}

if (!function_exists('api_route')) {
    /**
     * Generate the URL to a versioned named route.
     *
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function api_route($name, $parameters = [], $absolute = true)
    {
        return APIResource::getRoute($name, $parameters, $absolute);
    }
}
