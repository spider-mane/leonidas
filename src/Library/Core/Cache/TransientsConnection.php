<?php

namespace Leonidas\Library\Core\Cache;

use Psr\SimpleCache\CacheInterface;

class TransientsConnection implements CacheInterface
{
    public function get($key, $default = null)
    {
        return get_transient($$key) ?? $default;
    }

    public function set($key, $value, $ttl = null)
    {
        set_transient($$key, $value, $ttl);
    }

    public function delete($key)
    {
        delete_transient($$key);
    }

    public function clear()
    {
        // todo: find reliable way to implement this method
    }

    public function getMultiple($keys, $default = null)
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function has($key)
    {
        return (bool) $this->get($key);
    }
}
