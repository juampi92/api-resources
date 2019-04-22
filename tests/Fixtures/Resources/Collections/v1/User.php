<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Collections\v1;

use JsonSerializable;
use Juampi92\APIResources\Tests\Fixtures\Arrayable;
use Illuminate\Http\Resources\Json\Resource;

class User extends Resource implements Arrayable
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'v' => 1,
        ];
    }
}
