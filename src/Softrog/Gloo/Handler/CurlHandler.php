<?php

namespace Softrog\Gloo\Handler;

use Softrog\Gloo\Psr\Http\Message\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Softrog\Gloo\Psr\Stream\StringStream;

class CurlHandler extends HandlerAbstract
{

  /** @var Resource */
  protected $channel;

  /**
   * Initialize the handler.
   *
   * @throws \Exception
   */
  public function __construct()
  {
    if (!function_exists('curl_init')) {
      throw new \Exception('Curl library is not installed in this host.');
    }

    $this->channel = curl_init();
  }

  /**
   * Destroy the handler.
   */
  public function __destruct()
  {
    curl_close($this->channel);
  }

  /**
   * {@inheritdoc}
   */
  public function delete(RequestInterface $request)
  {
    return $this->request($request->withMethod('DELETE'));
  }

  /**
   * {@inheritdoc}
   */
  public function get(RequestInterface $request)
  {
    return $this->request($request->withMethod('GET'));
  }

  /**
   * {@inheritdoc}
   */
  public function head(RequestInterface $request)
  {
    return $this->request($request->withMethod('HEAD'));
  }

  /**
   * {@inheritdoc}
   */
  public function post(RequestInterface $request)
  {
    return $this->request($request->withMethod('POST'));
  }

  /**
   * {@inheritdoc}
   */
  public function put(RequestInterface $request)
  {
    return $this->request($request->withMethod('PUT'));
  }

  /**
   * Magic to handle other methods not defined by the interface
   *
   * @param type $method
   * @param type $arguments
   * @return ResponseInterface
   * @throws \InvalidArgumentException
   */
  public function __call($method, $arguments)
  {
    $request = array_shift($arguments);

    if (!$request instanceof RequestInterface) {
      throw new \InvalidArgumentException(
        'The request argument has to be a valid Psr\Http\Message\RequestInterface'
      );
    }

    return $this->request($request->withMethod($method));
  }

  /**
   * Perform a request against the given URL $url
   *
   * @param string $url
   * @param string $method
   * @return ResponseInterface
   */
  protected function request(RequestInterface $request)
  {
    curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, $request->getMethod());
    curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->channel, CURLOPT_VERBOSE, 1);
    curl_setopt($this->channel, CURLOPT_HEADER, 1);
    curl_setopt($this->channel, CURLOPT_URL, (string)$request->getUri());

    $headers = $request->getHeaders();

    if (!empty($request->getBody()) && $request->getBody()->getSize() > 0) {
      curl_setopt($this->channel, CURLOPT_POSTFIELDS, $request->getBody()->getContents());
      $headers['Content-Length'] = strlen($request->getBody()->getContents());
    }

    curl_setopt($this->channel, CURLOPT_HTTPHEADER, $this->adaptHeaders($headers));

    return $this->parseResponse(curl_exec($this->channel));
  }

  /**
   * Transform an array of headers to a valid format for the curl library
   *
   * @param array $headers
   * @return array
   */
  protected function adaptHeaders(array $headers)
  {
    $outputHeaders = [];
    foreach ($headers as $name => $value) {
      $outputHeaders[] = sprintf('%s: %s', $name, is_array($value)? implode(';', $value) : $value);
    }

    return $outputHeaders;
  }

  /**
   * Parse the response from the host
   *
   * @param mixed $data
   * @return Response
   * @throws \Exception
   */
  protected function parseResponse($data)
  {
    $header_size = curl_getinfo($this->channel, CURLINFO_HEADER_SIZE);
    $header = substr($data, 0, $header_size);
    $headLines = explode("\n", trim($header));

    $status = array_shift($headLines);
    if (!preg_match('/^(?<version>[^ ]+) (?<statusCode>[^ ]+) (?<reason>.+)$/', $status, $matches)) {
      throw new \Exception('Wrong response from server');
    }

    $response = (new Response())
      ->withStatus($matches['statusCode'], $matches['reason'])
      ->withBody(new StringStream(substr($data, $header_size)));


    $addHeaders = function (&$array, ResponseInterface $response, callable $callback) {
      $item = each($array);
      if (!$item) {
        return $response;
      }
      list($name, $value) = explode(":", $item['value']);
      return $callback($array, $response, $callback)->withHeader($name, $value);
    };

    return $addHeaders($headLines, $response, $addHeaders);

  }
}