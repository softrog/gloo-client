<?php

namespace Softrog\Gloo\Handler;

use Psr\Http\Message\RequestInterface;

abstract class HandlerAbstract implements HandlerInterface
{

  /**
   * {@inheritdoc}
   */
  public function delete(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('DELETE');
  }

  /**
   * {@inheritdoc}
   */
  public function get(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('GET');
  }

  /**
   * {@inheritdoc}
   */
  public function head(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('HEAD');
  }

  /**
   * {@inheritdoc}
   */
  public function options(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('OPTIONS');
  }

  /**
   * {@inheritdoc}
   */
  public function patch(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('PATH');
  }

  /**
   * {@inheritdoc}
   */
  public function post(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('POST');
  }

  /**
   * {@inheritdoc}
   */
  public function put(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('PUT');
  }

  /**
   * {@inheritdoc}
   */
  public function trace(RequestInterface $request)
  {
    throw new Exception\MethodNotImplementedException('TRACE');
  }

}
