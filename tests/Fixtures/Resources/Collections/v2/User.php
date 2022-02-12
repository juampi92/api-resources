<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Collections\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
