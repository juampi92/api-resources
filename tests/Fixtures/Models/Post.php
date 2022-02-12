<?php

namespace Juampi92\APIResources\Tests\Fixtures\Models;



class User
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
        'body' => 'Lorem Ipsum'
      ];
    }
}
