<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v1;

use Illuminate\Http\Resources\Json\Resource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class User extends Resource implements Arrayable
{
    public function toArray($request)
    {
        return [
      'id'   => $this->id,
      'name' => $this->name,
      'rank' => api_resource('App\Rank')->make($this->rank()),
      'v'    => 1,
    ];
    }
}
