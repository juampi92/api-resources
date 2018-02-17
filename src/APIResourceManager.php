<?php

namespace Juampi92\APIResources;

use Exception;

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
    protected $api_name;
    /**
     * @var string
     */
    protected $resources;

    /**
     * API Resource constructor
     *
     */
    public function __construct()
    {
        $name = config('api.default', null);
        $v = $this->getConfig('api.version', $name);

        if (!$v) {
            throw new Exception('You must define a config(\'api\') with a latest version. Do: php artisan vendor:publish --provider="Juampi92/APIResources/APIResourcesServiceProvider"');
        }

        $this->latest = $v;
        $this->setVersion($v, $name);
    }

    /**
     *  Get config considering the API name if present
     *
     * @param string $cfg  Config path
     * @param string $name Name of api if present
     *
     * @return mixed The result of the config
     */
    protected function getConfig($cfg, $name = null)
    {
        if (is_null($name)) {
            $name = $this->api_name;
        }

        return config($cfg . ($name ? ".$name" : ''));
    }

    /**
     * Sets the current API version
     *
     * @param string $current
     * @param string $api_name = null
     *
     * @return $this
     */
    public function setVersion($current, $api_name = null)
    {
        $this->current = $current;
        $this->api_name = $api_name;
        $this->latest = $this->getConfig('api.version');

        // Path can be only one or one for each api
        $this->path = config('api.resources_path');
        if (is_array($this->path)) {
            $this->path = $this->getConfig('api.resources_path');
        }

        $this->resources = $this->getConfig('api.resources');

        return $this;
    }

    /**
     * Gets the current API version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->current;
    }

    /**
     * Checks if the given version is the latest
     *
     * @param string $c
     *
     * @return string
     */
    public function isLatest($c = null)
    {
        if (!isset($c)) {
            $c = $this->current;
        }

        return $this->latest === $c;
    }

    /**
     * Returns the classname with the version considering
     *
     * @param string $classname
     * @param bool $forceLatest Set to true if last version is required
     *
     * @return string
     */
    public function resolveClassname($classname, $forceLatest = false)
    {
        $v = $forceLatest ? $this->latest : $this->current;

        if (!empty($this->resources)) {
            $path = $this->resources . "\\v{$v}\\" . str_after($classname, $this->resources . "\\");
        } else {
            $path = "v{$v}\\" . $classname;
        }

        $path = "\\" . $this->path . "\\" . $path;

        return $path;
    }

    /**
     * Smart builds the classname using the correct version.
     * If it fails with the current version, it falls back to
     * the latest version. If it still fails, throw exception
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
