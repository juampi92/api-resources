<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\App\v2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Users extends ResourceCollection
{
    protected $asd = 'not';

    public function setAsd($val)
    {
        $this->asd = $val;

        return $this;
    }

    public function toArray($request)
    {
        return [
      'data' => api_resource('App\User')->collection($this->collection),
      'asd' => $this->asd,
    ];
    }
}
