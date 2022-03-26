<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v1\Posts;

use Illuminate\Http\Resources\Json\JsonResource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class Single extends JsonResource implements Arrayable
{
    public function toArray($request)
    {
        return [
      'id' => $this->id,
      'title' => $this->title,
    ];
    }
}
