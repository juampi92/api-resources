<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use JsonSerializable;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class Rank extends JsonResource implements Arrayable
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
