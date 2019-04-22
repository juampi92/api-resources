<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use Illuminate\Http\Resources\Json\Resource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class Rank extends Resource implements Arrayable
{
    public function toArray($request)
    {
        return [
      'id'   => $this->id,
      'name' => $this->name,
      'v'    => 2,
    ];
    }
}
