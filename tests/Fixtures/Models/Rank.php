<?php

namespace Juampi92\APIResources\Tests\Fixtures\Models;

use Juampi92\APIResources\Tests\Fixtures\Arrayable;

class Rank implements Arrayable
{
  // Simulate Eloquent's dynamic attributes
  public $id = 1;
  public $name = 'adm';

  public function toArray($request)
  {
    return [
      'id' => 1,
      'name' => 'adm'
    ];
  }
}
