<?php

namespace Juampi92\APIResources\Tests\Fixtures\Models;

use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class User implements Arrayable
{
    // Simulate Eloquent's dynamic attributes
    public $id = 2;
    public $title = 'asdasd';
    public $body = 'Lorem Ipsum';

    public function toArray($request)
    {
        return [
        'id' => 2,
        'title' => 'asdasd',
        'body' => 'Lorem Ipsum',
      ];
    }
}
