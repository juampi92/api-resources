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

    public function test_it_can_get_multiple_route_paths()
    {
        config([
            'api.route_prefix' => [
                'app' => 'this_is_custom',
                'default' => 'wow',
            ],
            'api.resources' => [
                'app' => 'App2',
                'default' => 'Apii',
            ]]);
        $resourceManager = new APIResourceManager();

        $resourceManager->setVersion('1', 'app');
        $this->assertEquals('this_is_custom.v1.auth.login', $resourceManager->getRouteName('this_is_custom.auth.login'));

        $resourceManager->setVersion('1', 'default');
        $this->assertEquals('wow.v1.auth.login', $resourceManager->getRouteName('wow.auth.login'));
    }

    public function test_it_can_get_subdomains()
    {
        config([
            'api.route_prefix' => 'app.api',
            'api.resources' => 'App\API',
        ]);
        $resourceManager = new APIResourceManager();

        $resourceManager->setVersion('1');
        $this->assertEquals('app.api.v1.auth.login', $resourceManager->getRouteName('app.api.auth.login'));
    }

    public function test_it_can_get_subdomains_by_default()
    {
        config([
            'api.resources' => 'App\API\Web',
        ]);
        $resourceManager = new APIResourceManager();

        $resourceManager->setVersion('1');
        $this->assertEquals('app.api.web.v1.auth.login', $resourceManager->getRouteName('app.api.web.auth.login'));
    }
}
