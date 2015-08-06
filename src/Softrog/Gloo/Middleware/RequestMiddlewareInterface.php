<?php

namespace Softrog\Gloo\Middleware;

use Psr\Http\Message\RequestInterface;

interface RequestMiddlewareInterface extends MiddlewareInterface
{
  /**
   * Perform actions over the request object.
   *
   * @param RequestInterface $request
   * @return RequestInterface
   */
  public function onRequest(RequestInterface $request);
}
