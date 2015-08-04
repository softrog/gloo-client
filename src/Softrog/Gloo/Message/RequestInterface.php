<?php

namespace Softrog\Gloo\Message;

interface RequestInterface extends MessageInterface
{

  /**
   * Set the request method.
   *
   * @param string $method
   * @return RequestInterface
   */
  public function setMethod($method);

  /**
   * Get the request method.
   *
   * @return string
   */
  public function getMethod();

  /**
   * Set the request url.
   *
   * @param string $url
   * @return RequestInterface
   */
  public function setUrl($url);

  /**
   * Get the request url
   *
   * @return string
   */
  public function getUrl();
}
