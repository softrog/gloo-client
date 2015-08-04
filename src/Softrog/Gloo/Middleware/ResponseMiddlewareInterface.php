<?php

namespace Softrog\Gloo\Middleware;

use Softrog\Gloo\Message\ResponseInterface;

interface ResponseMiddlewareInterface extends MiddlewareInterface
{

  /**
   * Perform actions over the response object
   *
   * @param ResponseInterface $response
   * @return boolean true if successful, false otherwise
   */
  public function onResponse(ResponseInterface $response);
}
