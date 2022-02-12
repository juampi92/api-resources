<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Api\v1\Posts;

use Illuminate\Http\Resources\Json\JsonResource;

class Single extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title
    ];
  }
}
