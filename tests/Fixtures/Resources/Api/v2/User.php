<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'rank' => api_resource('App\Rank')
        ->make($this->rank()),
      'v' => 2
    ];
  }
}
