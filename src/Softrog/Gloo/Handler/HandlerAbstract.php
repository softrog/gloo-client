<?php

namespace Softrog\Gloo\Handler;

abstract class HandlerAbstract implements HandlerInterface
{

  /**
   * {@inheritdoc}
   */
  public function delete($uri)
  {
    throw new Exception\MethodNotImplementedException('DELETE');
  }

  /**
   * {@inheritdoc}
   */
  public function get($uri)
  {
    throw new Exception\MethodNotImplementedException('GET');
  }

  /**
   * {@inheritdoc}
   */
  public function head($uri)
  {
    throw new Exception\MethodNotImplementedException('HEAD');
  }

  /**
   * {@inheritdoc}
   */
  public function options($uri)
  {
    throw new Exception\MethodNotImplementedException('OPTIONS');
  }

  /**
   * {@inheritdoc}
   */
  public function patch($uri)
  {
    throw new Exception\MethodNotImplementedException('PATH');
  }

  /**
   * {@inheritdoc}
   */
  public function post($uri)
  {
    throw new Exception\MethodNotImplementedException('POST');
  }

  /**
   * {@inheritdoc}
   */
  public function put($uri)
  {
    throw new Exception\MethodNotImplementedException('PUT');
  }

  /**
   * {@inheritdoc}
   */
  public function trace($uri)
  {
    throw new Exception\MethodNotImplementedException('TRACE');
  }

}
