<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v1\Posts;

use Illuminate\Http\Resources\Json\Resource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class Single extends Resource implements Arrayable
{
    public function toArray($request)
    {
        return [
      'id'    => $this->id,
      'title' => $this->title,
    ];
    }
}
