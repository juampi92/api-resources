<?php

namespace Juampi92\APIResources\Tests\Fixtures\Resources\Collections\v2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Juampi92\APIResources\Facades\APIResource;

class UserCollection extends ResourceCollection
{
    protected function collects()
    {
        return APIResource::resolveClassname('Collections\User');
    }
}
