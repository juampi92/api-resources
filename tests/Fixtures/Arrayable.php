<?php

namespace Juampi92\APIResources\Tests\Fixtures;

interface Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray($request);
}
