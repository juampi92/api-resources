<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\APIResourceManager;
use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;

class BasicTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/Fixtures/config/simple.php']);
    }

    public function test_it_can_construct()
    {
        $object = new APIResourceManager();
        $this->assertInstanceOf(APIResourceManager::class, $object);
    }

    public function test_it_defaults_correctly()
    {
        config(['api' => [
            'version' => '2',
            'resources_path' => 'App\Resources',
            'resources' => 'Api',
        ],
        ]);
        $object = new APIResourceManager();
        $this->assertAttributeEquals('2', 'current', $object);
        $this->assertAttributeEquals('App\Resources', 'path', $object);
        $this->assertAttributeEquals('Api', 'resources', $object);

        config(['api' => [
            'version' => '1',
            'resources_path' => 'App\Resources2',
            'resources' => 'Api2',
        ],
        ]);
        $object->setVersion('2');
        $this->assertAttributeEquals('2', 'current', $object);
        $this->assertAttributeEquals('App\Resources2', 'path', $object);
        $this->assertAttributeEquals('Api2', 'resources', $object);
    }

    public function test_it_can_facade()
    {
        APIResourceFacade::setVersion('2');
        $this->assertEquals('2', APIResourceFacade::getVersion());

        APIResourceFacade::setVersion('5');
        $this->assertEquals('5', APIResourceFacade::getVersion());
    }
}
