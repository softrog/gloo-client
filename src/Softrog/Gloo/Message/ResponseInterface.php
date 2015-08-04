<?php

namespace Softrog\Gloo\Message;

use Softrog\Gloo\Message\RequestInterface;

interface ResponseInterface extends MessageInterface
{

  /**
   * Set the response status code.
   *
   * @return ResponseInterface
   */
  public function setStatusCode($statusCode);

  /**
   * Get the response status code.
   *
   * @return integer
   */
  public function getStatusCode();

  /**
   * Set the response reason
   *
   * @param string $reason
   * @return ResponseInterface
   */
  public function setReason($reason);

  /**
   * Get the response reason.
   *
   * @return string
   */
  public function getReason();

  /**
   * Set the response body.
   *
   * @param string $body
   * @return ResponseInterface
   */
  public function setBody($body);

  /**
   * Get the response body.
   *
   * @return mixed
   */
  public function getBody();

  /**
   * Set the request that resulted in this response.
   *
   * @param RequestInterface $request
   * @return RequestInterface
   */
  public function setRequest(RequestInterface $request);

  /**
   * Get the request that resulted in this current response.
   *
   * @return RequestInterface
   */
  public function getRequest();
}
