<?php

namespace Juampi92\APIResources\Tests;

use Juampi92\APIResources\Facades\APIResource as APIResourceFacade;

class APIResourceCollectionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Reset config on each request
        config(['api' => require __DIR__ . '/Fixtures/config/simple.php']);
    }

    public function test_simple_resource_with_collection()
    {
        $users = collect([new Fixtures\Models\User(), new Fixtures\Models\User()]);

        APIResourceFacade::setVersion('2');
        $resource = api_resource('App\User')->collection($users);

        $this->assertResourceArray($resource, [
            [
                'id' => 1,
                'name' => 'asd',
                'rank' => [
                    'id' => 1,
                    'name' => 'adm',
                    'v' => 2,
                ],
                'v' => 2,
            ], [
                'id' => 1,
                'name' => 'asd',
                'rank' => [
                    'id' => 1,
                    'name' => 'adm',
                    'v' => 2,
                ],
                'v' => 2,
            ],
        ]);
    }

    public function test_collection_resource()
    {
        $users = collect([new Fixtures\Models\User(), new Fixtures\Models\User()]);

        APIResourceFacade::setVersion('2');

        $asd = 'random';

        $resource = api_resource('App\Users')
            ->make($users)
            ->setAsd($asd);

        $this->assertResourceArray($resource, ['data' => [
            [
                'id' => 1,
                'name' => 'asd',
                'rank' => [
                    'id' => 1,
                    'name' => 'adm',
                    'v' => 2,
                ],
                'v' => 2,
            ], [
                'id' => 1,
                'name' => 'asd',
                'rank' => [
                    'id' => 1,
                    'name' => 'adm',
                    'v' => 2,
                ],
                'v' => 2,
            ],
        ],
            'asd' => $asd,
        ]);
    }

    /** @group asd */
    public function test_versioned_collection()
    {
        config(['api' => require __DIR__ . '/Fixtures/config/multi.php']);
        $users = collect([new Fixtures\Models\User(), new Fixtures\Models\User()]);

        APIResourceFacade::setVersion('1', 'collection');

        $resource = api_resource('Collections\UserCollection')
            ->make($users);

        $this->assertResourceArray($resource, [
            [
                'id' => 1,
                'name' => 'asd',
                'v' => 1,
            ], [
                'id' => 1,
                'name' => 'asd',
                'v' => 1,
            ],
        ]);
    }
}
