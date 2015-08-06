<?php

namespace Softrog\Gloo\Client\Exception;

class MaxRetriesExceededException extends \Exception
{
  /**
   * {@inheritdoc}
   */
  protected $message = 'The client has tried to many times without getting a valid response';

}
