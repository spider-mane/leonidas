<?php

namespace Leonidas\Library\Admin\Repository;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Component\Notice\AdminNoticeCollection;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;

class AdminNoticeRepository implements AdminNoticeRepositoryInterface
{
    protected const CACHE_KEY = 'admin_notices';

    protected AdminNoticeCollectionInterface $notices;

    public function __construct(protected CacheInterface $cache)
    {
        $this->notices = $this->getInitialNotices();
    }

    public function add(AdminNoticeInterface $notice)
    {
        $this->notices->add($notice);
    }

    public function batch(AdminNoticeInterface ...$notices)
    {
        foreach ($notices as $notice) {
            $this->add($notice);
        }
    }

    public function collect(AdminNoticeCollectionInterface $collection)
    {
        $this->notices->batch(...$collection->toArray());
    }

    public function get(string $notice): AdminNoticeInterface
    {
        return $this->notices->get($notice);
    }

    public function select(string ...$notices): AdminNoticeCollectionInterface
    {
        return new AdminNoticeCollection(
            ...array_map([$this, 'get'], $notices)
        );
    }

    public function forField(string $field): AdminNoticeCollectionInterface
    {
        return new AdminNoticeCollection(...array_filter(
            $this->all()->toArray(),
            fn (AdminNoticeInterface $notice) => $notice->getField() === $field
        ));
    }

    public function all(): AdminNoticeCollectionInterface
    {
        return $this->notices;
    }

    public function remove(string $notice): void
    {
        $this->notices->remove($notice);
    }

    public function has(string $notice): bool
    {
        return $this->notices->has($notice);
    }

    public function persist(ServerRequestInterface $request): void
    {
        $key = static::CACHE_KEY;

        if ('GET' === $request->getMethod() && $this->cache->has($key)) {
            $this->cache->delete($key);
        } elseif ($this->notices->hasItems()) {
            $this->cache->set($key, $this->all());
        }
    }

    protected function getInitialNotices(): AdminNoticeCollectionInterface
    {
        return $this->cache->get(
            static::CACHE_KEY,
            new AdminNoticeCollection()
        );
    }
}
