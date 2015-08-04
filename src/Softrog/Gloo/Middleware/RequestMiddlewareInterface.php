<?php

namespace Softrog\Gloo\Middleware;

use Softrog\Gloo\Message\RequestInterface;

interface RequestMiddlewareInterface extends MiddlewareInterface
{
  /**
   * Perform actions over the request object.
   *
   * @param RequestInterface $request
   * @return boolean true if successful, false otherwise
   */
  public function onRequest(RequestInterface $request);
}
