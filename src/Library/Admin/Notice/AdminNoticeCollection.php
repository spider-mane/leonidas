<?php

namespace Leonidas\Library\Admin\Notice;

use Leonidas\Contracts\Admin\Components\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;

class AdminNoticeCollection implements AdminNoticeCollectionInterface
{
    /**
     * @var AdminNoticeInterface[]
     */
    protected array $notices;

    public function __construct(AdminNoticeInterface ...$notices)
    {
        $this->addMany(...$notices);
    }

    public function toArray(): array
    {
        return array_values($this->notices);
    }

    public function get(string $notice): AdminNoticeInterface
    {
        return $this->notices[$notice];
    }

    public function getForScreen(string $screen): AdminNoticeCollectionInterface
    {
        return new AdminNoticeCollection(
            ...array_column($this->notices, 'screen', $screen)
        );
    }

    public function getForUser(string $user): AdminNoticeCollectionInterface
    {
        return new AdminNoticeCollection(
            ...array_column($this->notices, 'user', $user)
        );
    }

    public function add(AdminNoticeInterface $notice)
    {
        $this->notices[$notice->getId()] = $notice;
    }

    public function addMany(AdminNoticeInterface ...$notices)
    {
        array_map([$this, 'add'], $notices);
    }

    public function getMap(): array
    {
        return $this->notices;
    }

    public function has(string $notice): bool
    {
        return isset($this->notices[$notice]);
    }

    public function remove(string $notice)
    {
        unset($this->notices[$notice]);
    }
}
