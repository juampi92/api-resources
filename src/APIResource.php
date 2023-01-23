<?php

namespace Juampi92\APIResources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @template TResource of JsonResource
 */
class APIResource
{
    /** @var class-string<TResource> */
    protected $path;

    /**
     * @param class-string<TResource> $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed ...$args
     *
     * @return JsonResource
     */
    public function with(...$args)
    {
        return forward_static_call_array([$this->path, 'make'], $args);
    }

    /**
     * @param mixed ...$args
     *
     * @return JsonResource
     */
    public function make(...$args)
    {
        return forward_static_call_array([$this->path, 'make'], $args);
    }

    /**
     * @param mixed ...$args
     *
     * @return JsonResource
     */
    public function collection(...$args)
    {
        return forward_static_call_array([$this->path, 'collection'], $args);
    }
}
