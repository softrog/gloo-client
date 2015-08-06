<?php

namespace Softrog\Gloo\Psr\Stream;

use Psr\Http\Message\StreamInterface;

class StringStream implements StreamInterface
{

  /** @var string */
  protected $string;

  public function __construct($string)
  {
    $this->string = $string;
  }

  /**
   * {@inheritdoc}
   */
  public function __toString()
  {
    return $this->string();
  }

  /**
   * {@inheritdoc}
   */
  public function close()
  {
    $this->string = '';
  }

  /**
   * {@inheritdoc}
   */
  public function detach()
  {
    $this->string = '';
  }

  /**
   * {@inheritdoc}
   */
  public function eof()
  {
    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function getContents()
  {
    return $this->string;
  }

  /**
   * {@inheritdoc}
   */
  public function getMetadata($key = null)
  {

  }

  /**
   * {@inheritdoc}
   */
  public function getSize()
  {
    return strlen($this->string);
  }

  /**
   * {@inheritdoc}
   */
  public function isReadable()
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function isSeekable()
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function isWritable()
  {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function read($length)
  {
    throw new \RuntimeException('The stream is not readable');
  }

  /**
   * {@inheritdoc}
   */
  public function rewind()
  {
    throw new \RuntimeException('The stream is not seekable');
  }

  /**
   * {@inheritdoc}
   */
  public function seek($offset, $whence = SEEK_SET)
  {
    throw new \RuntimeException('The stream is not seekable');
  }

  /**
   * {@inheritdoc}
   */
  public function tell()
  {
    throw new \RuntimeException('The stream is not seekable');
  }

  /**
   * {@inheritdoc}
   */
  public function write($string)
  {
    throw new \RuntimeException('The stream is not writable');
  }

}
