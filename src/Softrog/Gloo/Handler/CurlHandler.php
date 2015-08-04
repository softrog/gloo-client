<?php

namespace Softrog\Gloo\Handler;

use Softrog\Gloo\Message\Response;
use Softrog\Gloo\Message\RequestInterface;

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
    $request->setMethod('DELETE');
    return $this->request($request, 'DELETE');
  }

  /**
   * {@inheritdoc}
   */
  public function get(RequestInterface $request)
  {
    $request->setMethod('GET');
    return $this->request($request, 'GET');
  }

  /**
   * {@inheritdoc}
   */
  public function head(RequestInterface $request)
  {
    $request->setMethod('HEAD');
    return $this->request($request, 'HEAD');
  }

  /**
   * {@inheritdoc}
   */
  public function post(RequestInterface $request)
  {
    $request->setMethod('POST');
    return $this->request($request, 'POST');
  }

  /**
   * {@inheritdoc}
   */
  public function put(RequestInterface $request)
  {
    $request->setMethod('PUT');
    return $this->request($request, 'PUT');
  }

  /**
   * Perform a request against the given URL $url
   *
   * @param string $url
   * @param string $method
   * @return Response
   */
  protected function request(RequestInterface $request)
  {
    curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, $request->getMethod());
    curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->channel, CURLOPT_VERBOSE, 1);
    curl_setopt($this->channel, CURLOPT_HEADER, 1);
    curl_setopt($this->channel, CURLOPT_URL, $request->getUrl());
    curl_setopt($this->channel, CURLOPT_HTTPHEADER, $this->adaptHeaders($request->getHeaders()));

    $response = $this->parseResponse(curl_exec($this->channel));
    $response->setRequest($request);

    return $response;
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
      $outputHeaders[] = sprintf('%s: %s', $name, $value);
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
    $response = new Response();

    $header_size = curl_getinfo($this->channel, CURLINFO_HEADER_SIZE);
    $header = substr($data, 0, $header_size);
    $response->setBody(substr($data, $header_size));

    $headLines = explode("\n", trim($header));

    $status = array_shift($headLines);
    if (!preg_match('/^(?<version>[^ ]+) (?<statusCode>[^ ]+) (?<reason>.+)$/', $status, $matches)) {
      throw new \Exception('Wrong response from server');
    }

    $response->setStatusCode($matches['statusCode']);
    $response->setReason($matches['reason']);
    foreach ($headLines as $header) {
      list($name, $value) = explode(":", $header);
      $response->addHeader(trim($name), trim($value));
    }

    return $response;
  }

}
