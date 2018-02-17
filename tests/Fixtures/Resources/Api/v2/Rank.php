<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v2;

use JsonSerializable;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;
use Illuminate\Http\Resources\Json\Resource;

class Rank extends Resource implements Arrayable
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'v' => 2
    ];
  }
}
