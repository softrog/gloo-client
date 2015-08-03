<?php

namespace Softrog\Gloo\Client;

use Softrog\Gloo\Handler;
use Softrog\Gloo\Response\Response;
use Softrog\Gloo\Configuration\ClientConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Softrog\Gloo\Handler\HandlerInterface;

class Client
{
  /** @var array */
  private $configuration;

  /** @var HandlerInterface */
  private $handler;

  /** @var Object */
  private $serializer=null;

  /**
   * Build a client with configuration $configuration
   *
   * Configuration parameters:
   *  - base_uri: base uri for the request
   *  - headers: custom headers to send along with the request
   *
   * @param array $configuration
   */
  public function __construct($configuration)
  {
    $this->configuration = $this->processConfiguration($configuration);

    $this->handler = new Handler\CurlHandler();
  }

  public function __call($name, $arguments)
  {
    $callback = [$this->handler, $name];

    if (!is_callable($callback)) {
      $message = sprintf("Method %s is not a valid HTTP method", $name);
      throw new \Exception($message);
    }

    $uri = $this->getUrl(array_shift($arguments));
    array_unshift($arguments, $uri);

    $response = call_user_func_array($callback, $arguments);

    return $this->deserialize($response);
  }

  /**
   * Set a serializer to serialize/deserialize requests and responses
   *
   * @param Object $serializer
   * @return \Softrog\Gloo\Client\Client
   */
  public function setSerializer($serializer)
  {
    $this->serializer = $serializer;

    return $this;
  }

  /**
   * Deserialize response body
   *
   * @param Response $response
   * @return Response
   */
  protected function deserialize(Response $response)
  {
    if (!is_null ($this->serializer)) {
      $format = $this->parseMimeType($response->getHeader('Content-Type'));
      $response->setBody($this->serializer->deserialize($response->getBody(), 'array', $format));
    }

    return $response;
  }

  /**
   * Build the correct url to request based in the configuration and the current request
   *
   * @param string $uri
   * @return string
   */
  protected function getUrl($uri)
  {
    return $this->configuration['base_uri'] . $uri;
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
   * Guess what format is the response to tell the serializer
   * @todo a lot to improve here
   *
   * @param type $type
   * @return string
   */
  protected function parseMimeType($type)
  {
    switch ($type) {
      case 'application/json':
        return 'json';
    }
  }

}
