<?php

namespace Softrog\Gloo\Handler;

use Softrog\Gloo\Message\RequestInterface;

interface HandlerInterface
{

  /**
   * Place a delete request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function delete(RequestInterface $request);

  /**
   * Place a get request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function get(RequestInterface $request);

  /**
   * Place a head request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function head(RequestInterface $request);

  /**
   * Place a options request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function options(RequestInterface $request);

  /**
   * Place a patch request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function patch(RequestInterface $request);

  /**
   * Place a post request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function post(RequestInterface $request);

  /**
   * Place a put request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function put(RequestInterface $request);

  /**
   * Place a trace request to the URI $uri
   *
   * @param RequestInterface $request
   */
  public function trace(RequestInterface $request);
}
