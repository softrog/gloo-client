<?php

namespace Softrog\Gloo\Client\Exception;

class UnexpectedResponseReceivedException extends \Exception
{
  public function __construct($message=null)
  {
    $message = "The response has to be a valid Psr\Http\Message\ResponseInterface\n" . $message;

    parent::__construct($message);
  }
}
