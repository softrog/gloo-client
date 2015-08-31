<?php

namespace Softrog\Gloo\Psr\Http\Message;

use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{
  protected $status = [
    100 => 'Continue								',
    101 => 'Switching Protocols',
    102 => 'Processing',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',
    208 => 'Already Reported',
    226 => 'IM Used',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => 'Switch Proxy',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',
    308 => 'Resume Incomplete',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Payload Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',
    419 => 'Authentication Timeout',
    420 => 'Method Failure',
    420 => 'Enhance Your Calm',
    421 => 'Misdirected Request',
    422 => 'Unprocessable Entity',
    423 => 'Locked',
    424 => 'Failed Dependency',
    426 => 'Upgrade Required',
    428 => 'Precondition Required',
    429 => 'Too Many Requests',
    431 => 'Request Header Fields Too Large',
    440 => 'Login Timeout',
    444 => 'No Response',
    449 => 'Retry With',
    450 => 'Blocked by Windows Parental Controls',
    451 => 'Unavailable For Legal Reasons',
    451 => 'Redirect',
    494 => 'Request Header Too Large',
    495 => 'Cert Error',
    496 => 'No Cert',
    497 => 'HTTP to HTTPS',
    498 => 'Token expired/invalid',
    499 => 'Client Closed Request',
    499 => 'Token required',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates',
    507 => 'Insufficient Storage',
    508 => 'Loop Detected',
    509 => 'Bandwidth Limit Exceeded',
    510 => 'Not Extended',
    511 => 'Network Authentication Required',
    520 => 'Unknown Error',
    522 => 'Origin Connection Time-out',
    598 => 'Network read timeout error',
    599 => 'Network connect timeout error',
  ];

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
