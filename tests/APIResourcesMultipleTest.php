<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;
use Juampi92\APIResources\APIResourceManager;
use Juampi92\APIResources\APIResource;
use Juampi92\APIResources\Exceptions\ResourceNotFoundException;

class APIResourcesMultipleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/Fixtures/config/multi.php']);
    }

    public function test_nested_resources_with_fallback()
    {
        config(['api.version' => [
            'app'     => '2',
            'desktop' => '1'
        ]]);
        $resourceManager = new APIResourceManager();

        $user = new Fixtures\Models\User();

        $resourceManager->setVersion('1', 'app');
        $resource = $resourceManager->resolve('App\User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\App\v1\User::class, $resource);

        /**
         * Now change to the desktop API
         */

        $resourceManager->setVersion('2', 'desktop');
        $resource = $resourceManager->resolve('Api\User')->make($user);

        $this->assertInstanceOf(Fixtures\Resources\Api\v2\User::class, $resource);
    }
}
