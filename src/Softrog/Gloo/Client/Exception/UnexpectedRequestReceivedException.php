<?php

namespace Softrog\Gloo\Client\Exception;

class UnexpectedRequestReceivedException extends \Exception
{
  public function __construct($message=null)
  {
    $message = "The request has to be a valid Psr\Http\Message\RequestInterface\n" . $message;

    parent::__construct($message);
  }
}
