<?php

namespace Softrog\Gloo\Response;

class Response implements ResponseInterface
{

  protected $headers = [];
  protected $body = "";
  protected $statusCode = null;
  protected $reason = "";

  public function setBody($body)
  {
    $this->body = $body;

    return $this;
  }

  public function getBody()
  {
    return $this->body;
  }

  public function setHeaders(array $headers)
  {
    $this->headers = $headers;

    return $this;
  }

  public function addHeader($name, $value)
  {
    $this->headers[$name] = $value;

    return $this;
  }

  public function hasHeader($name)
  {
    return array_key_exists($name, $this->headers);
  }

  public function getHeader($name)
  {
    if ($this->hasHeader($name)) {
      return $this->headers[$name];
    }

    return false;
  }

  public function getHeaders()
  {
    return $this->headers;
  }

  public function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;

    return $this;
  }

  public function getStatusCode()
  {
    return $this->statusCode;
  }

  public function setReason($reason)
  {
    $this->reason = $reason;

    return $this;
  }

  public function getReason()
  {
    return $this->reason;
  }

}
