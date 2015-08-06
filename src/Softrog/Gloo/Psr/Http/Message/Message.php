<?php

namespace Softrog\Gloo\Psr\Http\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{

  /** @var array */
  protected $headers = [];

  /** @var mixed */
  protected $body = "";

  /** @var string */
  protected $version;

  /**
   * {@inheritdoc}
   */
  public function getProtocolVersion()
  {
    return $this->version;
  }

  /**
   * {@inheritdoc}
   */
  public function withProtocolVersion($version)
  {
    if (!preg_match('/^\d+\.\d+$/', $version)) {
      throw new \Exception(sprintf('Invalid protocol version \'%s\'', $version));
    }

    $message = clone $this;
    $message->version = $version;

    return $message;
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
  public function withBody(StreamInterface $body)
  {
    $message = clone $this;
    $message->body = $body;

    return $message;
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
  public function getHeaderLine($name)
  {
    $headerLine = '';

    if (array_key_exists($name, $this->headers)) {
      $headerLine = implode(',', $this->headers[$name]);
    }

    return $headerLine;
  }

  /**
   * {@inheritdoc}
   */
  public function withHeader($name, $value)
  {
    $message = clone $this;

    if (is_array($value)) {
      $message->headers[$name] = $value;
    } else {
      $message->headers[$name] = [$value];
    }

    return $message;
  }

  /**
   * {@inheritdoc}
   */
  public function withAddedHeader($name, $value)
  {
    if (!array_key_exists($name, $this->headers)) {
      return $this->withHeader($name, $value);
    }

    $message = clone $this;

    if (is_array($value)) {
      $message->headers[$name] += $value;
    } else {
      $message->headers[$name][] = $value;
    }

    return $message;
  }

  /**
   * {@inheritdoc}
   */
  public function withoutHeader($name)
  {
    $message = clone $this;

    if (array_key_exists($name, $message->headers)) {
      unset($message->headers[$name]);
    }

    return $message;
  }

}
