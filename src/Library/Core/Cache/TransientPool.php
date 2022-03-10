<?php

namespace Leonidas\Library\Core\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class TransientPool implements CacheItemPoolInterface
{
    /**
     * @var CacheItemInterface[]
     */
    protected array $deferred = [];

    /**
     * {@inheritDoc}
     */
    public function getItem($key)
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function getItems(array $keys = [])
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function hasItem($key): bool
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function deleteItem($key)
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            $this->deleteItem($key);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function save(CacheItemInterface $item)
    {
        set_transient($item->getKey(), $item->get());
    }

    /**
     * {@inheritDoc}
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        $this->deferred[$item->getKey()] = $item;
    }

    /**
     * {@inheritDoc}
     */
    public function commit()
    {
        //
    }
}
