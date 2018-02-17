<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use JsonSerializable;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;
use Illuminate\Http\Resources\Json\Resource;

class Post extends Resource implements Arrayable
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'title' => $this->title
    ];
  }
}
