<?php

namespace Juampi92\APIResources\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Juampi92\APIResources\APIResourcesServiceProvider;

abstract class TestCase extends BaseTestCase
{
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
        //$req = request();
        $arr = json_encode($array);
        $this->assertAttributeEquals($arr, 'data', $resource->response());
    }

    public function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
