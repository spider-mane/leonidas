<?php

namespace Leonidas\Library\Admin\Notice;

use Leonidas\Contracts\Admin\Components\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;

class AdminNoticeRepository implements AdminNoticeRepositoryInterface
{
    protected string $channel;

    protected CacheInterface $cache;

    protected AdminNoticeCollectionInterface $notices;

    public function __construct(string $channel, CacheInterface $cache)
    {
        $this->channel = $channel;
        $this->cache = $cache;
    }

    public function get(string $notice): AdminNoticeInterface
    {
        return $this->cache->get($notice);
    }

    public function all(): AdminNoticeCollectionInterface
    {
        return $this->notices;
    }

    public function add(AdminNoticeInterface $notice)
    {
        $this->notices->add($notice);
    }

    public function addMany(AdminNoticeInterface ...$notices)
    {
        foreach ($notices as $notice) {
            $this->add($notice);
        }
    }

    public function addCollection(AdminNoticeCollectionInterface $collection)
    {
        $this->notices->addMany(...$collection->toArray());
    }

    public function getCollection(string ...$notices): AdminNoticeCollectionInterface
    {
        return new AdminNoticeCollection(...array_map([$this, 'get'], $notices));
    }

    public function remove(string $notice)
    {
        $this->notices->remove($notice);
    }

    public function clear()
    {
        $this->notices = new AdminNoticeCollection();
    }

    public function reset(AdminNoticeInterface ...$notices)
    {
        $this->notices = new AdminNoticeCollection(...$notices);
    }

    public function has(string $notice): bool
    {
        return $this->notices->has($notice);
    }

    public function persist(ServerRequestInterface $request): void
    {
        $this->cache->set("{$this->channel}.admin_notices", $this->notices);
    }

    public function toArray(): array
    {
        return $this->notices->toArray();
    }

    public function count(): int
    {
        return count($this->toArray());
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }
}
