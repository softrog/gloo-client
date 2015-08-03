<?php

namespace Softrog\Gloo\Handler;

interface HandlerInterface
{

  /**
   * Place a delete request to the URI $uri
   *
   * @param string $uri
   */
  public function delete($uri);

  /**
   * Place a get request to the URI $uri
   *
   * @param string $uri
   */
  public function get($uri);

  /**
   * Place a head request to the URI $uri
   *
   * @param string $uri
   */
  public function head($uri);

  /**
   * Place a options request to the URI $uri
   *
   * @param string $uri
   */
  public function options($uri);

  /**
   * Place a patch request to the URI $uri
   *
   * @param string $uri
   */
  public function patch($uri);

  /**
   * Place a post request to the URI $uri
   *
   * @param string $uri
   */
  public function post($uri);

  /**
   * Place a put request to the URI $uri
   *
   * @param string $uri
   */
  public function put($uri);

  /**
   * Place a trace request to the URI $uri
   *
   * @param string $uri
   */
  public function trace($uri);

  /**
   * Get last request response status code
   *
   * @return int
   */
  public function getStatusCode();

  /**
   * Get last request response reason
   *
   * @return string
   */
  public function getReason();

  /**
   * Get last request response headers
   *
   * @return array
   */
  public function getHeaders();

  /**
   * Get last request response body
   *
   * @return string
   */
  public function getBody();
}
