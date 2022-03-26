<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class Post extends JsonResource implements Arrayable
{
    public function toArray($request)
    {
        return [
      'id' => $this->id,
      'title' => $this->title,
    ];
    }
}
