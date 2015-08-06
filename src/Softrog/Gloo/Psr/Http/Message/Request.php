<?php

namespace Softrog\Gloo\Psr\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{

  protected $validMethods = [
      'GET',
      'HEAD',
      'POST',
      'PUT',
      'DELETE',
      'TRACE',
      'OPTIONS',
      'CONNECT',
      'PATCH',
  ];

  /** @var string */
  protected $method;

  /** @var UriInterface */
  protected $uri;

  /** @var string */
  protected $requestTarget;

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
  public function withMethod($method)
  {
    if (!in_array(strtoupper($method), $this->validMethods)) {
      throw new \InvalidArgumentException(sprintf('Invalid method \'%s\'', $method));
    }

    $request = clone $this;
    $request->method = $method;

    return $request;
  }

  /**
   * {@inheritdoc}
   */
  public function getRequestTarget()
  {
    return $this->requestTarget;
  }

  /**
   * {@inheritdoc}
   */
  public function withRequestTarget($requestTarget)
  {
    $request = clone $this;
    $request->requestTarget = $requestTarget;

    return $request;
  }

  /**
   * {@inheritdoc}
   */
  public function getUri()
  {
    return $this->uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withUri(UriInterface $uri, $preserveHost = false)
  {
    $request = clone ($this);
    $host = parse_url($uri, PHP_URL_HOST);
    if ($preserveHost) {
      if ((!$request->hasHeader('Host') or empty($request->getHeder('Host'))) && !empty($host)) {
        $request->headers['Host'] = [$host];
      }
    } else {
      $request->headers['Host'] = [$host];
    }

    $request->uri = $uri;

    return $request;
  }

}
