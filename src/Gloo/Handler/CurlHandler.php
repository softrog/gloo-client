<?php

namespace Softrog\Gloo\Handler;

use Softrog\Gloo\Response\Response;

class CurlHandler extends HandlerAbstract
{

  /** @var Resource */
  protected $channel;

  public function __construct()
  {
    if (!function_exists('curl_init')) {
      throw new \Exception('Curl library is not installed in this host.');
    }

    $this->channel = curl_init();
  }

  public function __destruct()
  {
    curl_close($this->channel);
  }

  /**
   * {@inheritdoc}
   */
  public function delete($uri)
  {
    return $this->request($uri, 'DELETE');
  }

  /**
   * {@inheritdoc}
   */
  public function get($uri)
  {
    return $this->request($uri, 'GET');
  }

  /**
   * {@inheritdoc}
   */
  public function head($uri)
  {
    return $this->request($uri, 'HEAD');
  }

  /**
   * {@inheritdoc}
   */
  public function post($uri)
  {
    return $this->request($uri, 'POST');
  }

  /**
   * {@inheritdoc}
   */
  public function put($uri)
  {
    return $this->request($uri, 'PUT');
  }

  /**
   * {@inheritdoc}
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**
   * {@inheritdoc}
   */
  public function getReason()
  {
    return $this->reason;
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
  public function getBody()
  {
    return $this->body;
  }

  /**
   * Perform a request against the given URL $url
   *
   * @param string $url
   * @param string $method
   * @return Response
   */
  protected function request($url, $method)
  {
    curl_setopt($this->channel, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->channel, CURLOPT_VERBOSE, 1);
    curl_setopt($this->channel, CURLOPT_HEADER, 1);
    curl_setopt($this->channel, CURLOPT_URL, $url);

    return $this->parseResponse(curl_exec($this->channel));
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
    if (!preg_match('/^(?<version>[^ ]+) (?<statusCode>[^ ]+) (?<reason>[^ ]+)$/', $status, $matches)) {
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
