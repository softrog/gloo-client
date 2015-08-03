<?php

namespace Softrog\Gloo\Handler\Exception;

class MethodNotImplementedException extends \Exception
{
  public function __construct($message, $code, $previous)
  {
    $processedMessage = sprintf("The method '%s' is not implemented yet for this handler.", $message);
    parent::__construct($processedMessage, $code, $previous);
  }
}
