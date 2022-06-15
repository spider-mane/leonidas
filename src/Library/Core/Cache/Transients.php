<?php

namespace Leonidas\Library\Core\Cache;

use Psr\SimpleCache\CacheInterface;

class Transients implements CacheInterface
{
    public function get($key, $default = null)
    {
        return get_transient($key) ?? $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        return set_transient($key, $value, $ttl);
    }

    public function delete($key): bool
    {
        return delete_transient($key);
    }

    public function clear(): bool
    {
        // todo: find reliable way to implement this method
        return false;
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
        return (bool) $this->get($key);
    }
}
