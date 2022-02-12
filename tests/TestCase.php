<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Juampi92\APIResources\APIResourcesServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        APIResourceFacade::clearResolvedInstances();
    }

    /**
     * @param \Illuminate\Foundation\Application $application
     *
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [APIResourcesServiceProvider::class];
    }

    /**
     * @param $resource
     * @param $array
     */
    protected function assertResourceArray($resource, $array)
    {
        $this->assertEquals(json_encode($array), json_encode($resource));
    }

    public function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
