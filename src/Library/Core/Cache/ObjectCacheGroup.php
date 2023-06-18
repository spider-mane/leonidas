<?php

namespace Leonidas\Library\Core\Cache;

use Psr\SimpleCache\CacheInterface;

class ObjectCacheGroup implements CacheInterface
{
    protected string $group;

    protected array $keys;

    public function __construct(string $group = 'default')
    {
        $this->group = $group;
    }

    public function get($key, $default = null): mixed
    {
        return wp_cache_get($key, $this->group) ?? $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        $this->addKey($key);

        return wp_cache_set($key, $value, $this->group, $ttl);
    }

    public function delete($key): bool
    {
        $this->removeKey($key);

        return wp_cache_delete($key, $this->group);
    }

    public function clear(): bool
    {
        foreach (array_unique($this->keys) as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has($key): bool
    {
        wp_cache_get($key, $this->group, false, $found);

        return $found;
    }

    protected function addKey(string $key)
    {
        $this->keys[] = $key;
    }

    protected function removeKey(string $key)
    {
        $this->keys = array_diff($this->keys, [$key]);
    }
}
