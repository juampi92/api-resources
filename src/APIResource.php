<?php

namespace Juampi92\APIResources;

use ReflectionClass;

class APIResource {

  protected $path;

  /**
   * API Resource constructor
   *
   */
  public function __construct($path)
  {
    $this->path = $path;
  }

  public function with(...$args)
  {
    return forward_static_call_array([$this->path, 'make'], $args);
  }

  public function make(...$args)
  {
    return forward_static_call_array([$this->path, 'make'], $args);
  }

  public function collection(...$args)
  {
    return forward_static_call_array([$this->path, 'collection'], $args);
  }

}
