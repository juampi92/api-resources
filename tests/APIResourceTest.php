<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;
use Juampi92\APIResources\APIResourceManager;
use Juampi92\APIResources\APIResource;
use Juampi92\APIResources\Exceptions\ResourceNotFoundException;

class APIResourceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/Fixtures/config/simple.php']);
    }

    public function test_manager_resolve_returns_a_resource()
    {
        APIResourceFacade::setVersion(config('app.version'));

        $object = APIResourceFacade::resolve('App\User');
        $this->assertInstanceOf(APIResource::class, $object);
    }

    public function _test_make_returns_a_class()
    {
        APIResourceFacade::setVersion(config('api.version'));

        APIResourceFacade::make('App\User', ['a' => 'b']);
    }

    public function test_api_resource_helper_returns_an_instance()
    {
        APIResourceFacade::setVersion('2');

        $resource = api_resource('App\User');
        $this->assertInstanceOf(APIResource::class, $resource);
        $this->assertAttributeEquals('\Juampi92\APIResources\Tests\Fixtures\Resources\App\v2\User', 'path', $resource);

        //$this->assertInstanceOf(APIResource::class, $object);
        //APIResourceFacade::make('App\User', [ 'a' => 'b']);
    }

    public function test_returns_resource()
    {
        $user = new Fixtures\Models\User();

        APIResourceFacade::setVersion('2');
        $resource = api_resource('App\User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\App\v2\User::class, $resource);

        $this->assertResourceArray($resource, ['data' => [
            'id'   => 1,
            'name' => 'asd',
            'rank' => [
                'id'   => 1,
                'name' => 'adm',
                'v'    => 2
            ],
            'v'    => 2,
        ]]);
    }

    public function test_fallback_to_latest_version()
    {
        // Set latest as 2
        config(['api.version' => 2]);
        $resourceManager = new APIResourceManager();

        $resourceManager->setVersion('1');

        $this->assertAttributeEquals(2, 'latest', $resourceManager);
        $this->assertAttributeEquals(1, 'current', $resourceManager);

        $resource = $resourceManager->resolve('App\Post');
        $this->assertAttributeEquals('\Juampi92\APIResources\Tests\Fixtures\Resources\App\v2\Post', 'path', $resource);
    }

    public function test_fails_if_no_fallback()
    {
        $this->expectException(ResourceNotFoundException::class);

        // Set latest as 2
        config(['api.version' => 2]);
        $resourceManager = new APIResourceManager();

        $resource = $resourceManager->resolve('App\Comment');
    }

    public function test_nested_resources_simple()
    {
        $user = new Fixtures\Models\User();

        APIResourceFacade::setVersion('2');
        $resource = api_resource('App\User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\App\v2\User::class, $resource);

        $this->assertResourceArray($resource, ['data' => [
            'id'   => 1,
            'name' => 'asd',
            'rank' => [
                'id'   => 1,
                'name' => 'adm',
                'v'    => 2
            ],
            'v'    => 2,
        ]]);
    }

    public function test_nested_resources_with_fallback()
    {
        config(['api.version' => 2]);
        $resourceManager = new APIResourceManager();

        $user = new Fixtures\Models\User();

        $resourceManager->setVersion('1');
        $resource = $resourceManager->resolve('App\User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\App\v1\User::class, $resource);

        $this->assertResourceArray($resource, ['data' => [
            'id'   => 1,
            'name' => 'asd',
            'rank' => [
                'id'   => 1,
                'name' => 'adm',
                'v'    => 2
            ],
            'v'    => 1,
        ]]);
    }


    public function test_without_resource_folder()
    {
        config(['api.resources' => '']);
        $resourceManager = new APIResourceManager();

        $user = new Fixtures\Models\User();

        $resourceManager->setVersion('1');
        $resource = $resourceManager->resolve('User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\v1\User::class, $resource);

        $this->assertResourceArray($resource, ['data' => [
            'id'   => 1,
            'name' => 'asd',
            'v'    => 1,
        ]]);
    }
}
