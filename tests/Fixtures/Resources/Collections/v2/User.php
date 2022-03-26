<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Collections\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class User extends JsonResource implements Arrayable
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'v' => 2,
        ];
    }
}
