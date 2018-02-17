<?php

namespace Juampi92\APIResources;

class APIResource
{

    protected $path;

    /**
     * API Resource constructor
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param array ...$args
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function with(...$args)
    {
        return forward_static_call_array([$this->path, 'make'], $args);
    }

    /**
     * @param array ...$args
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function make(...$args)
    {
        return forward_static_call_array([$this->path, 'make'], $args);
    }

    /**
     * @param array ...$args
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function collection(...$args)
    {
        return forward_static_call_array([$this->path, 'collection'], $args);
    }

}
