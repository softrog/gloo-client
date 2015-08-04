<?php

namespace Softrog\Gloo\Message;

interface MessageInterface
{

  /**
   * Set the request headers.
   *
   * @param array $headers
   * @return MessageInterface
   */
  public function setHeaders(array $headers);

  /**
   * Add a header to the list.
   *
   * @param string $name
   * @param string $value
   * @return MessageInterface
   */
  public function addHeader($name, $value);

  /**
   * Get the request headers.
   *
   * @return array
   */
  public function getHeaders();

  /**
   * Check if the request has the header.
   *
   * @param string $name
   */
  public function hasHeader($name);

  /**
   * Get the $name header in the request.
   *
   * @param string $name
   */
  public function getHeader($name);
}
