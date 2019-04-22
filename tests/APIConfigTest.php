<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\APIResourceManager;

class APIConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__.'/../publishable/config/api.php']);
    }

    public function test_it_can_get_nested_routes()
    {
        config(['api.resource' => [
            'app' => $appResource = 'App',
            'api' => $apiResource = 'API',
        ]]);
        $resourceManager = new APIResourceManager();
        $resourceManager->setVersion('1', 'app');

        $config = $this->callMethod($resourceManager, 'getConfig', ['resource']);
        $this->assertEquals($appResource, $config);

        $config = $this->callMethod($resourceManager, 'getConfig', ['resource', 'api']);
        $this->assertEquals($apiResource, $config);
    }

    public function test_it_can_get_non_nested_routes()
    {
        config(['api.resource' => 'WebApp']);
        $resourceManager = new APIResourceManager();
        $resourceManager->setVersion('2');

        $config = $this->callMethod($resourceManager, 'getConfig', ['resource']);
        $this->assertEquals('WebApp', $config);
    }
}
