<?php

namespace Juampi92\APIResources\Tests\Fixtures\Models;

class Rank
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
