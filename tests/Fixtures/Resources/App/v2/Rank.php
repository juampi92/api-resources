<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class Rank extends JsonResource
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
