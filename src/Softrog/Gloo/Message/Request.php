<?php

namespace Softrog\Gloo\Message;

class Request implements RequestInterface
{

  /** @var string */
  protected $method;

  /** @var string */
  protected $url;

  /** @var array */
  protected $headers = [];

  /**
   * {@inheritdoc}
   */
  public function getMethod()
  {
    return $this->method;
  }

  /**
   * {@inheritdoc}
   */
  public function setMethod($method)
  {
    $this->method = $method;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * {@inheritdoc}
   */
  public function setUrl($url)
  {
    $this->url = $url;

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
  public function getHeader($name)
  {
    if ($this->hasHeader($name)) {
      return $this->headers[$name];
    }

    return null;
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
  public function hasHeader($name)
  {
    return array_key_exists($name, $this->headers);
  }

  /**
   * {@inheritdoc}
   */
  public function setHeaders(array $headers)
  {
    $this->headers = $headers;
  }

}
