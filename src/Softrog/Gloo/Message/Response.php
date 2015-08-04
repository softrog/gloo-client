<?php

namespace Softrog\Gloo\Message;

class Response implements ResponseInterface
{

  /** @var array */
  protected $headers = [];

  /** @var mixed */
  protected $body = "";

  /** @var int */
  protected $statusCode = null;

  /** @var string */
  protected $reason = "";

  /** @var RequestInterface */
  protected $request;

  /**
   * {@inheritdoc}
   */
  public function setBody($body)
  {
    $this->body = $body;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getBody()
  {
    return $this->body;
  }

  /**
   * {@inheritdoc}
   */
  public function setHeaders(array $headers)
  {
    $this->headers = $headers;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addHeader($name, $value)
  {
    $this->headers[$name] = $value;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function hasHeader($name)
  {
    return array_key_exists($name, $this->headers);
  }

  /**
   * {@inheritdoc}
   */
  public function getHeader($name)
  {
    if ($this->hasHeader($name)) {
      return $this->headers[$name];
    }

    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function getHeaders()
  {
    return $this->headers;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**
   * {@inheritdoc}
   */
  public function setReason($reason)
  {
    $this->reason = $reason;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getReason()
  {
    return $this->reason;
  }

  /**
   * {@inheritdoc}
   */
  public function setRequest(RequestInterface $request)
  {
    $this->request = $request;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getRequest()
  {
    return $this->request;
  }

}
