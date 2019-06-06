<?php

namespace Juampi92\APIResources;

use Exception;
use Juampi92\APIResources\Exceptions\ResourceNotFoundException;

class APIResourceManager
{
    /**
     * @var string
     */
    protected $current;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $apiName;
    /**
     * @var string
     */
    protected $resources;
    /**
     * @var string
     */
    protected $latest;
    /**
     * @var string
     */
    protected $routePath;

    /**
     * API Resource constructor.
     *
     */
    public function __construct()
    {
        $defaultName = config('api.default', null);
        $latestVersion = $this->getConfig('version', $defaultName);

        if (!$latestVersion) {
            throw new Exception('You must define a config(\'api\') with a latest version. Do: php artisan vendor:publish --provider="Juampi92/APIResources/APIResourcesServiceProvider"');
        }

        $this->latest = $latestVersion;
        $this->setVersion($latestVersion, $defaultName);
    }

    /**
     * Returns the name of the versioned route.
     *
     * @param string $route
     * @return string
     */
    public function getRouteName($route)
    {
        // Get the route prefix, which sould be in 'route_prefix' or at least in 'resources' (in lowercase here)
        $routePrefix = preg_replace('/^([a-z_-]+)\..*/', '$1', $route);
        // Checks for $routePrefix in the config in case there is no default API or the requested one is different
        if(
            // 'resources' needs to be an array in case there is more than one API
            is_array(config('api.resources')) &&
            // AND the default differs from the requested prefix
            $this->apiName !== $routePrefix &&
            // AND $routePrefix needs to be a valid key in 'resources'
            array_key_exists($routePrefix, config('api.resources')))
        {
            // The requested API is valid, so get the arrays' values
            $apiVersion = $this->getConfig('version', $routePrefix);
            $routePath = $this->getConfig('route_prefix', $routePrefix)
                ?: str_replace('\\', '.', strtolower($this->getConfig('resources', $routePrefix)));
        }
        else {
            // Original code
            if(! $this->routePath) {
                // Grab route_prefix config first. If it's not set,
                // grab the resources, and replace `\` with `.`, and
                // transform it all to lowercase.
                $this->routePath = $this->getConfig('route_prefix')
                    ?: str_replace('\\', '.', strtolower($this->getConfig('resources')));
            }
            $apiVersion = $this->current;
            $routePath = $this->routePath;
        }

        return "{$routePath}.v{$apiVersion}" . str_after($route, $routePath);
    }

    /**
     * Returns the versioned url.
     *
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    public function getRoute($name, $parameters = [], $absolute = true)
    {
        return route($this->getRouteName($name), $parameters, $absolute);
    }

    /**
     *  Get config considering the API name if present.
     *
     * @param string $cfg Config path
     * @param string $name Name of api if present
     *
     * @return mixed The result of the config
     */
    protected function getConfig($cfg, $name = null)
    {
        if (is_null($name)) {
            $name = $this->apiName;
        }

        $name = $name ? ".$name" : '';

        return config("api.$cfg{$name}");
    }

    /**
     * Sets the current API version.
     *
     * @param string $current
     * @param string $apiName = null
     *
     * @return $this
     */
    public function setVersion($current, $apiName = null)
    {
        // Reset pre-cached properties
        $this->current = $current;
        $this->apiName = $apiName;

        $this->routePath = null;
        $this->latest = $this->getConfig('version');

        // Path can be only one or one for each api
        $this->path = config('api.resources_path');
        if (is_array($this->path)) {
            $this->path = $this->getConfig('resources_path');
        }

        $this->resources = $this->getConfig('resources');

        return $this;
    }

    /**
     * Gets the current API version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->current;
    }

    /**
     * Checks if the given version is the latest.
     *
     * @param string $current
     *
     * @return bool
     */
    public function isLatest($current = null)
    {
        if (!isset($current)) {
            $current = $this->current;
        }

        return $this->latest === $current;
    }

    /**
     * Returns the classname of the versioned resource,
     * or it's latest version if it doesn't exist.
     *
     * Throws an exception if it cannot find it.
     *
     * @param string $classname
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function resolveClassname($classname)
    {
        $path = $this->parseClassname($classname);

        // Check if the resource was found
        if (class_exists($path)) {
            return $path;
        }

        // If we are on the latest version, stop searching
        if ($this->isLatest()) {
            throw new Exceptions\ResourceNotFoundException($classname, $path);
        }

        // Search on the latest version
        $path = $this->parseClassname($classname, true);

        // If still does not exists, fail
        if (!class_exists($path)) {
            throw new Exceptions\ResourceNotFoundException($classname, $path);
        }

        return $path;
    }

    /**
     * Returns the classname with the version considering.
     *
     * @param string $classname
     * @param bool $forceLatest Set to true if last version is required
     *
     * @return string
     */
    protected function parseClassname($classname, $forceLatest = false)
    {
        $version = $forceLatest ? $this->latest : $this->current;

        if (!empty($this->resources)) {
            $path = $this->resources . "\\v{$version}\\" . str_after($classname, $this->resources . "\\");
        } else {
            $path = "v{$version}\\" . $classname;
        }

        $path = "\\{$this->path}\\{$path}";

        return $path;
    }

    /**
     * Smart builds the classname using the correct version.
     * If it fails with the current version, it falls back to
     * the latest version. If it still fails, throw exception.
     *
     * @param string $classname
     *
     * @return APIResource
     * @throws Exceptions\ResourceNotFoundException
     */
    public function resolve($classname)
    {
        $path = $this->resolveClassname($classname);

        // Check if the resource was found
        if (!class_exists($path)) {

            // If we are on the latest version, stop searching
            if ($this->isLatest()) {
                throw new Exceptions\ResourceNotFoundException($classname, $path);
            }

            // Search on the latest version
            $path = $this->resolveClassname($classname, true);

            // If still does not exists, fail
            if (!class_exists($path)) {
                throw new Exceptions\ResourceNotFoundException($classname, $path);
            }
        }

        return new APIResource($path);
    }

    /**
     * @param string $classname
     * @param array $args
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function make($classname, ...$args)
    {
        $resource = $this->resolve($classname);
        return $resource->make(...$args);
    }

    /**
     * @param string $classname
     * @param array ...$args
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function collection($classname, ...$args)
    {
        $resource = $this->resolve($classname);
        return $resource->collection(...$args);
    }
}
