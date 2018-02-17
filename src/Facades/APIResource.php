<?php
namespace Juampi92\APIResources\Facades;

use Illuminate\Support\Facades\Facade;

class APIResource extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apiresource';
    }
}
