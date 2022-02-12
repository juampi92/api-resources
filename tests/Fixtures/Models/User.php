<?php

namespace Juampi92\APIResources\Tests\Fixtures\Models;



class User
{
  // Simulate Eloquent's dynamic attributes
  public $id = 1;
  public $name = 'asd';

  public function posts()
  {
    return [
      new Post()
    ];
  }

  public function rank()
  {
    return new Rank();
  }

  public function toArray($request)
  {
    return [
      'id' => 1,
      'name' => 'asd',
      'posts' => [
        new Post()
      ]
    ];
  }
}
