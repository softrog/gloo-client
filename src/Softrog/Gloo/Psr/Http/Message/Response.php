<?php

namespace Softrog\Gloo\Psr\Http\Message;

use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{

  /** @var int */
  protected $statusCode = null;

  /** @var string */
  protected $reasonPhrase = "";


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
  public function getReasonPhrase()
  {
    return $this->reasonPhrase;
  }

  /**
   * {@inheritdoc}
   */
  public function withStatus($code, $reasonPhrase = '')
  {
    $response = clone $this;
    $response->statusCode = $code;
    $response->reasonPhrase = $reasonPhrase;

    return $response;
  }

}
