<?php

namespace Softrog\Gloo\Client;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Softrog\Gloo\Handler;
use Softrog\Gloo\Handler\HandlerInterface;
use Softrog\Gloo\Psr\Http\Message\Response;
use Softrog\Gloo\Psr\Http\Message\Request;
use Softrog\Gloo\Psr\Http\Message\Uri;
use Softrog\Gloo\Configuration\ClientConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Softrog\Gloo\Middleware\MiddlewareInterface;
use Softrog\Gloo\Middleware\RequestMiddlewareInterface;
use Softrog\Gloo\Middleware\ResponseMiddlewareInterface;
use Softrog\Gloo\Middleware\HeaderMiddleware;

class Client
{

  /** @var array */
  protected $configuration;

  /** @var HandlerInterface */
  protected $handler;

  /** @var MiddlewareInterface[] */
  protected $middleware;

  /** @var integer */
  protected $tries;

  /**
   * Build a client with configuration $configuration
   *
   * Configuration parameters:
   *  - base_uri: base uri for the request
   *  - headers: custom headers to send along with the request
   *
   * @param array $configuration
   */
  public function __construct($configuration=[])
  {
    $this->configuration = $this->processConfiguration($configuration);
    $this->handler = new Handler\CurlHandler();

    $headers = [];
    if (array_key_exists('headers', $this->configuration)) {
      $headers = $this->configuration['headers'];
    }

    $this->push(new HeaderMiddleware($headers));
  }

  /**
   * Call automagically the handler method $method.
   *
   * @param string $method
   * @param array $arguments
   * @return ResponseInterface
   * @throws \Exception If the given method doesn't exist for the handler.
   */
  public function __call($method, $arguments)
  {
    $callback = [$this->handler, $method];

    if (!is_callable($callback)) {
      $message = sprintf("Method %s is not a valid HTTP method", $method);
      throw new \Exception($message);
    }

    $this->tries = $this->configuration['max_tries'];

    $request = (new Request())
      ->withMethod($method)
      ->withUri($this->getUri(array_shift($arguments)));

    return $this->processRequest($request);
  }

  /**
   * Add middleware to the client.
   *
   * @param MiddlewareInterface $middleware
   */
  public function push(MiddlewareInterface $middleware)
  {
    if (!is_array($this->middleware)) {
      $this->middleware = [];
    }

    $this->middleware[] = $middleware;
  }

  /**
   * Process and validate the given configuration
   *
   * @param array $configs
   * @return array
   */
  protected function processConfiguration($configs)
  {
    $processor = new Processor();
    $configuration = new ClientConfiguration();

    return $processor->processConfiguration($configuration, ['configuration' => $configs]);
  }

  /**
   * Process the request before sending it.
   *
   * @param RequestInterface $request
   * @return ResponseInterface
   * @throws Exception\MaxRetriesExceededException
   */
  protected function processRequest(RequestInterface $request)
  {
    foreach ($this->middleware as $middleware) {
      if ($middleware instanceof RequestMiddlewareInterface) {
        $request = $middleware->onRequest($request);
      }
    }

    $callback = [$this->handler, $request->getMethod()];
    $response = call_user_func($callback, $request);

    if ($this->tries <= 0) {
      throw new Exception\MaxRetriesExceededException();
    }

    return $this->processResponse($request, $response);
  }

  /**
   * Process the request response.
   *
   * @param ResponseInterface $response
   * @return ResponseInterface
   */
  protected function processResponse(RequestInterface $request, ResponseInterface $response)
  {
    foreach ($this->middleware as $middleware) {
      if ($middleware instanceof ResponseMiddlewareInterface) {
        $response = $middleware->onResponse($response);
        if (is_null($response)) {
          $this->tries--;
          return $this->processRequest($request);
        }
      }
    }

    return $response;
  }

  /**
   * Build the correct url to request based in the configuration and the current request
   *
   * @param string $uri
   * @return string
   */
  protected function getUri($path)
  {
    if (!array_key_exists('base_uri', $this->configuration)) {
      return (new Uri())->withPath($path);
    }

    $components = $this->configuration['base_uri'];

    if (strpos('/', $path) !== 0) { // relative path
      $path = $components['path'] . $path;
    }

    return (new Uri())
      ->withScheme($components['scheme'])
      ->withHost($components['host'])
      ->withPort($components['port'])
      ->withPath($path);
  }

}
