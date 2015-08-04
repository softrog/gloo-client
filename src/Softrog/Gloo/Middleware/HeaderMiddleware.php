<?php

namespace Softrog\Gloo\Middleware;

use Softrog\Gloo\Message\RequestInterface;

class HeaderMiddleware implements RequestMiddlewareInterface
{

  /** @const */
  const USER_AGENT = "Gloobot/1.0";

  protected $headers;

  public function __construct(array $headers=[])
  {
    $this->headers = $headers;
  }

  /**
   *
   * @param RequestInterface $request
   */
  public function onRequest(RequestInterface $request)
  {
    $tokens = parse_url($request->getUrl());

    if (array_key_exists('host', $tokens)) {
      $request->addHeader('Host', $tokens['host']);
    }

    $request->addHeader('User-Agent', self::USER_AGENT);

    foreach ($this->headers as $name => $value) {
      $request->addHeader($name, $value);
    }
  }

}