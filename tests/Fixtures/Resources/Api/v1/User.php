<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v1;

use JsonSerializable;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource implements Arrayable
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'rank' => api_resource('App\Rank')->make($this->rank()),
      'v' => 1
    ];
  }
}
