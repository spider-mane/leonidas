<?php

namespace Leonidas\Contracts\Admin\Component\Notice;

use Leonidas\Contracts\Collection\ObjectCollectionInterface;

interface AdminNoticeCollectionInterface extends ObjectCollectionInterface
{
    public function add(AdminNoticeInterface $notice): bool;

    public function batch(AdminNoticeInterface ...$notices);

    public function get(string $notice): AdminNoticeInterface;

    public function has(string $notice): bool;

    /**
     * @return list<AdminNoticeInterface>
     */
    public function values(): array;

    /**
     * @return array<string, AdminNoticeInterface>
     */
    public function toArray(): array;

    public function remove(string $notice): bool;
}
