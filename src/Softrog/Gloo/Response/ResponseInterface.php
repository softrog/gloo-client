<?php

namespace Softrog\Gloo\Response;

interface ResponseInterface
{
  public function getStatusCode();

  public function getBody();

  public function getHeaders();

  public function getHeader($name);

  public function hasHeader($name);
}
