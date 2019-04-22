<?php

namespace Juampi92\APIResources\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Juampi92\APIResources\APIResourceManager setVersion(string $version, string $apiName = null)
 * @method static string getVersion()
 * @method static bool isLatest(string $c = null)
 * @method static string resolveClassname(string $classname, bool $forceLatest = null) Returns formatted classname using current version
 * @method static \Juampi92\APIResources\APIResource resolve(string $classname)
 * @method static \Illuminate\Http\Resources\Json\Resource make(string $classname, ...$args) Resolves the classname and instantiates the resource
 * @method static \Illuminate\Http\Resources\Json\Resource collection(string $classname, ...$args) Resolves the classname and instantiates the resource as a collection
 * @method static string getRoute(string $name, array $parameters, bool $absolute)
 * @method static string getRouteName(string $name)
 */
class APIResource extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apiresource';
    }
}
