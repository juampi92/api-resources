<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\APIResourceManager;
use Juampi92\APIResources\Facades\APIResource;

class ResourcePathResolveTest extends TestCase
{
    /**
     * @var APIResourceManager
     */
    protected $apiResourceManager;

    public function setUp(): void
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/../publishable/config/api.php']);

        $this->apiResourceManager = new APIResourceManager();
    }

    public function test_it_can_resolve_api_changes()
    {
        $this->apiResourceManager->setVersion('1');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['App\User']);
        $this->assertEquals('\\App\\Http\\Resources\\App\\v1\\User', $classname);

        $this->apiResourceManager->setVersion('2');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['App\Users']);
        $this->assertEquals('\\App\\Http\\Resources\\App\\v2\\Users', $classname);

        $this->apiResourceManager->setVersion('3');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['App\User\Single']);
        $this->assertEquals('\\App\\Http\\Resources\\App\\v3\\User\\Single', $classname);
    }

    public function test_it_can_resolve_resource_path_changes()
    {
        config(['api.resources_path' => 'App\Resources']);
        $this->apiResourceManager->setVersion('3');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['App\User']);
        $this->assertEquals('\\App\\Resources\\App\\v3\\User', $classname);

        config(['api.resources_path' => 'App\Resources2']);
        $this->apiResourceManager->setVersion('4');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['App\User']);
        $this->assertEquals('\\App\\Resources2\\App\\v4\\User', $classname);
    }

    public function test_it_can_resolve_resources_prefix_changes()
    {
        config(['api.resources' => 'Api']);
        $this->apiResourceManager->setVersion('1');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['Api\User']);
        $this->assertEquals('\\App\\Http\\Resources\\Api\\v1\\User', $classname);

        config(['api.resources' => 'Api\App']);
        $this->apiResourceManager->setVersion('1');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['Api\App\User']);
        $this->assertEquals('\\App\\Http\\Resources\\Api\\App\\v1\\User', $classname);
    }

    public function test_it_can_resolve_resources_prefix_empty()
    {
        config(['api.resources' => '']);
        $this->apiResourceManager->setVersion('1');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['User']);
        $this->assertEquals('\\App\\Http\\Resources\\v1\\User', $classname);

        config(['api.resources' => null]);
        $this->apiResourceManager->setVersion('1');
        $classname = $this->callMethod($this->apiResourceManager, 'parseClassname', ['User']);
        $this->assertEquals('\\App\\Http\\Resources\\v1\\User', $classname);
    }
}
