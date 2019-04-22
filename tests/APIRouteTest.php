<?php


namespace Juampi92\APIResources\Tests;


use Juampi92\APIResources\APIResourceManager;

class APIRouteTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/../publishable/config/api.php']);
    }

    public function test_it_can_get_default_route_prefix()
    {
        config(['api.resources' => 'App']);
        $resourceManager = new APIResourceManager();
        $resourceManager->setVersion('1');

        $this->assertEquals('app.v1.auth.login', $resourceManager->getRouteName('app.auth.login'));
    }

    public function test_it_can_get_custom_route_prefix()
    {
        config(['api.resources' => 'Api', 'api.route_prefix' => 'appp']);
        $resourceManager = new APIResourceManager();
        $resourceManager->setVersion('1');

        $this->assertEquals('appp.v1.auth.login', $resourceManager->getRouteName('appp.auth.login'));
    }

    public function test_it_can_get_multiple_resources()
    {
        config(['api.resources' => [
            'app' => 'App2',
            'default' => 'Apii',
        ]]);
        $resourceManager = new APIResourceManager();

        $resourceManager->setVersion('1', 'default');
        $this->assertEquals('apii.v1.auth.login', $resourceManager->getRouteName('apii.auth.login'));

        $resourceManager->setVersion('1', 'app');
        $this->assertEquals('app2.v1.auth.login', $resourceManager->getRouteName('app2.auth.login'));
    }
}
