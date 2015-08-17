<?php

namespace Softrog\Gloo\Psr\Http\Message;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{

  protected $schemeDefinition = [
      'ftp' => 21,
      'ftps' => 21,
      'gopher' => 70,
      'http' => 80,
      'https' => 443,
      'scp' => 22,
      'sftp' => 22,
      'tftp' => 69,
      'telnet' => 23,
      'dict' => 2628,
      'ldap' => 3268,
      'ldaps' => 3269,
      'imap' => 143,
      'pop3' => 110,
      'smtp' => 25,
      'rtsp' => 554,
  ];

  /** @var string */
  protected $scheme;

  /** @var string */
  protected $host;

  /** @var string */
  protected $port;

  /** @var string */
  protected $path;

  /** @var string */
  protected $query;

  /** @var string */
  protected $fragment;

  /** @var string */
  protected $user;

  /** @var string */
  protected $password;

  /**
   * {@inheritdoc}
   */
  public function __toString()
  {
    $str = $this->getScheme();

    if (!empty($str)) {
      $str .= '://';
    }

    $str .= $this->getAuthority();

    if (!empty($str) && strpos($this->getPath(), '/') !== 0) {
      $str .= '/';
    }

    $str .= $this->getPath();

    if (!empty($this->getQuery())) {
      $str .= '?' . $this->getQuery();
    }

    if (!empty($this->getFragment())) {
      $str .= '#' . $this->getFragment();
    }

    return $str;
  }

  /**
   * {@inheritdoc}
   */
  public function getAuthority()
  {
    return (empty($this->getUserInfo())? '' : $this->getUserInfo() . '@') .
            $this->getHost() .
            (empty($this->getPort())? '' : ':' . $this->getPort());
  }

  /**
   * {@inheritdoc}
   */
  public function getFragment()
  {
    return $this->fragment;
  }

  /**
   * {@inheritdoc}
   */
  public function getHost()
  {
    return $this->host;
  }

  /**
   * {@inheritdoc}
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * {@inheritdoc}
   */
  public function getPort()
  {
    if (!empty($this->scheme) && $this->schemeDefinition[$this->scheme] != $this->port or
            empty($this->scheme) && !empty($this->port)) {
      return $this->port;
    }

    return null;
  }

  /**
   * {@inheritdoc}
   */
  public function getQuery()
  {
    return $this->query;
  }

  /**
   * {@inheritdoc}
   */
  public function getScheme()
  {
    return $this->scheme;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserInfo()
  {
    return ($this->user? : '') .
            (empty($this->password)? '' : ':' . $this->password);
  }

  /**
   * {@inheritdoc}
   */
  public function withFragment($fragment)
  {
    $uri = clone $this;
    $uri->fragment = $fragment;

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withHost($host)
  {
    $uri = clone $this;
    $uri->host = strtolower($host);

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withPath($path)
  {
    $uri = clone $this;
    $uri->path = implode('/', array_map('urlencode', explode('/', $path)));

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withPort($port)
  {
    if (!is_null($port) && !is_numeric($port)) {
      throw new \InvalidArgumentException('Port has to be numeric');
    }
    $uri = clone $this;
    $uri->port = (int) $port;

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withQuery($query)
  {
    $uri = clone $this;
    $uri->query = $query;

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withScheme($scheme)
  {
    $scheme = strtolower($scheme);

    if (!empty($scheme) && !in_array($scheme, array_keys($this->schemeDefinition))) {
      throw new \InvalidArgumentException(sprintf('Scheme \'%s\' not supported', $scheme));
    }

    $uri = clone $this;
    $uri->scheme = strtolower($scheme);

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function withUserInfo($user, $password = null)
  {
    $uri = clone $this;
    $uri->user = $user;
    $uri->password = $password;

    return $uri;
  }

}
