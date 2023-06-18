<?php

namespace Leonidas\Library\Core\Cache;

use Psr\SimpleCache\CacheInterface;

class TransientsChannel extends Transients implements CacheInterface
{
    protected string $channel;

    protected string $separator = ':';

    public function __construct(string $channel)
    {
        $this->channel = $channel;
    }

    public function get($key, $default = null): mixed
    {
        return parent::get($this->identifier($key), $default);
    }

    public function set($key, $value, $ttl = null): bool
    {
        return parent::set($this->identifier($key), $value, $ttl);
    }

    public function delete($key): bool
    {
        return parent::delete($this->identifier($key));
    }

    public function clear(): bool
    {
        // todo: find reliable way to implement this method
        return false;
    }

    protected function identifier(string $key)
    {
        return $this->channel . $this->separator . $key;
    }
}
