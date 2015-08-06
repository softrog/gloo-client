<?php

namespace Softrog\Gloo\Middleware;

use Psr\Http\Message\ResponseInterface;

interface ResponseMiddlewareInterface extends MiddlewareInterface
{

  /**
   * Perform actions over the response object
   *
   * @param ResponseInterface $response
   * @return ResponseInterface
   */
  public function onResponse(ResponseInterface $response);
}
