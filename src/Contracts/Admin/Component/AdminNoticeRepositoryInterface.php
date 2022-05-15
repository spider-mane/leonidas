<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticeRepositoryInterface
{
    public function all(): AdminNoticeCollectionInterface;

    public function get(string $notice): AdminNoticeInterface;

    public function getCollection(string ...$notices): AdminNoticeCollectionInterface;

    public function add(AdminNoticeInterface $notice);

    public function addMany(AdminNoticeInterface ...$notices);

    public function addCollection(AdminNoticeCollectionInterface $collection);

    public function remove(string $notices);

    public function clear();

    public function reset(AdminNoticeInterface ...$notices);

    public function has(string $notice): bool;

    public function persist(ServerRequestInterface $request): void;

    /**
     * @return AdminNoticeInterface[]
     */
    public function toArray(): array;

    public function count(): int;

    public function isEmpty(): bool;
}
