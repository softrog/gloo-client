<?php

namespace Softrog\Gloo\Client;

use Softrog\Gloo\Middleware\MiddlewareInterface;

interface ClientInterface
{

  /**
   * Add middleware to the client.
   *
   * @param MiddlewareInterface $middleware
   */
  public function push(MiddlewareInterface $middleware);
}
