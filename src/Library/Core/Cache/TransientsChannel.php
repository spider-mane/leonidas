<?php

namespace Leonidas\Library\Core\Cache;

use Psr\SimpleCache\CacheInterface;

class TransientsChannel extends TransientsConnection implements CacheInterface
{
    protected string $channel;

    protected string $separator = ':';

    public function __construct(string $channel)
    {
        $this->channel = $channel;
    }

    public function get($key, $default = null)
    {
        return parent::get($this->identifier($key), $default);
    }

    public function set($key, $value, $ttl = null)
    {
        parent::set($this->identifier($key), $value, $ttl);
    }

    public function delete($key)
    {
        parent::delete($this->identifier($key));
    }

    public function clear()
    {
        // todo: find reliable way to implement this method
    }

    protected function identifier(string $key)
    {
        return $this->channel . $this->separator . $key;
    }
}
