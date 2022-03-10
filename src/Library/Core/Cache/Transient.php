<?php

namespace Leonidas\Library\Core\Cache;

use DateTimeInterface;
use Psr\Cache\CacheItemInterface;

class Transient implements CacheItemInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @var DateTimeInterface|null
     */
    protected $expiration = null;

    /**
     * @var bool
     */
    protected $isHit = false;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function isHit()
    {
        return $this->isHit;
    }

    /**
     * @inheritDoc
     */
    public function set($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function expiresAt($expiration)
    {
        $this->expiration = $expiration;
    }

    /**
     * {@inheritDoc}
     */
    public function expiresAfter($time)
    {
        //
    }
}
