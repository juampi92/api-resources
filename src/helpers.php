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
