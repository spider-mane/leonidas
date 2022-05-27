<?php

namespace Leonidas\Framework\Abstracts;

use Psr\SimpleCache\CacheInterface;

trait AccessesSimpleCacheTrait
{
    protected CacheInterface $simpleCache;

    protected function getSimpleCache(): CacheInterface
    {
        return $this->simpleCache;
    }

    protected function simpleCache(): CacheInterface
    {
        return $this->getService(CacheInterface::class);
    }
}
