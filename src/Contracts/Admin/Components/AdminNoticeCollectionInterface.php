<?php

namespace Leonidas\Contracts\Admin\Components;

interface AdminNoticeCollectionInterface
{
    /**
     * @return AdminNoticeInterface[]
     */
    public function toArray(): array;

    public function get(string $notice): AdminNoticeInterface;

    public function getForScreen(string $screen): AdminNoticeCollectionInterface;

    public function getForUser(string $user): AdminNoticeCollectionInterface;

    public function add(AdminNoticeInterface $notice);

    public function addMany(AdminNoticeInterface ...$notices);

    public function has(string $notice): bool;

    public function remove(string $notice);

    /**
     * @return AdminNoticeInterface[]
     */
    public function getMap(): array;
}
