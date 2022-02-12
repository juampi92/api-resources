<?php

namespace Juampi92\APIResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class APIResource
{
    /**
     * @param class-string<JsonResource|ResourceCollection> $class
     */
    public function __construct(
        /** @var class-string<JsonResource|ResourceCollection> $class */
        protected string $class,
    ) {}

    /**
     * @return class-string<JsonResource|ResourceCollection>
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param mixed ...$args
     * @return JsonResource
     */
    public function with(...$args)
    {
        return ($this->class)::make(...$args);
    }

    /**
     * @param mixed ...$args
     * @return JsonResource
     */
    public function make(...$args)
    {
        return ($this->class)::make(...$args);
    }

    /**
     * @param mixed ...$args
     * @return ResourceCollection<mixed>
     */
    public function collection(...$args)
    {
        return ($this->class)::collection(...$args);
    }
}
