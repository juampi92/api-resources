<?php

namespace Juampi92\APIResources\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Juampi92\APIResources\APIResourcesServiceProvider;
use ReflectionObject;

abstract class TestCase extends BaseTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [APIResourcesServiceProvider::class];
    }

    protected function assertResourceArray($resource, $array)
    {
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

    protected function assertAttributeEquals($expects, $attribute, $object): void
    {
        $class = new ReflectionObject($object);
        $property = $class->getProperty($attribute);
        $property->setAccessible(true);

        $this->assertEquals($expects, $property->getValue($object));
    }
}
