<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\Facades\APIResource;

class ResourcePathResolveTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/../publishable/config/api.php']);
    }

    public function test_it_can_resolve_api_changes()
    {
        APIresource::setVersion('1');
        $classname = APIResource::resolveClassname('App\User');
        $this->assertEquals('\\App\\Http\\Resources\\App\\v1\\User', $classname);

        APIresource::setVersion('2');
        $classname = APIResource::resolveClassname('App\Users');
        $this->assertEquals('\\App\\Http\\Resources\\App\\v2\\Users', $classname);

        APIresource::setVersion('3');
        $classname = APIResource::resolveClassname('App\User\Single');
        $this->assertEquals('\\App\\Http\\Resources\\App\\v3\\User\\Single', $classname);
    }

    public function test_it_can_resolve_resource_path_changes()
    {
        config(['api.resources_path' => 'App\Resources']);
        APIresource::setVersion('3');
        $classname = APIResource::resolveClassname('App\User');
        $this->assertEquals('\\App\\Resources\\App\\v3\\User', $classname);

        config(['api.resources_path' => 'App\Resources2']);
        APIresource::setVersion('4');
        $classname = APIResource::resolveClassname('App\User');
        $this->assertEquals('\\App\\Resources2\\App\\v4\\User', $classname);
    }

    public function test_it_can_resolve_resources_prefix_changes()
    {
        config(['api.resources' => 'Api']);
        APIresource::setVersion('1');
        $classname = APIResource::resolveClassname('Api\User');
        $this->assertEquals('\\App\\Http\\Resources\\Api\\v1\\User', $classname);

        config(['api.resources' => 'Api\App']);
        APIresource::setVersion('1');
        $classname = APIResource::resolveClassname('Api\App\User');
        $this->assertEquals('\\App\\Http\\Resources\\Api\\App\\v1\\User', $classname);
    }

    public function test_it_can_resolve_resources_prefix_empty()
    {
        config(['api.resources' => '']);
        APIresource::setVersion('1');
        $classname = APIResource::resolveClassname('User');
        $this->assertEquals('\\App\\Http\\Resources\\v1\\User', $classname);

        config(['api.resources' => null]);
        APIresource::setVersion('1');
        $classname = APIResource::resolveClassname('User');
        $this->assertEquals('\\App\\Http\\Resources\\v1\\User', $classname);
    }
}
