<?php

namespace Softrog\Gloo\Middleware;

use Psr\Http\Message\RequestInterface;

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
    $newRequest = $request
      ->withHeader('Host', $request->getUri()->getHost())
      ->withHeader('User-Agent', self::USER_AGENT);

    $addHeaders = function (&$array, RequestInterface $request, callable $callback) {
      $item = each($array);
      if (!$item) {
        return $request;
      }
      return $callback($array, $request, $callback)->withHeader($item['key'], $item['value']);
    };

    return $addHeaders($this->headers, $newRequest, $addHeaders);
  }

}
