<?php

namespace Leonidas\Contracts\Admin\Repository;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticeRepositoryInterface
{
    public function add(AdminNoticeInterface $notice);

    public function batch(AdminNoticeInterface ...$notices);

    public function collect(AdminNoticeCollectionInterface $collection);

    public function get(string $notice): AdminNoticeInterface;

    public function select(string ...$notices): AdminNoticeCollectionInterface;

    public function forField(string $field): AdminNoticeCollectionInterface;

    public function all(): AdminNoticeCollectionInterface;

    public function has(string $notice): bool;

    public function remove(string $notices): void;

    public function persist(ServerRequestInterface $request): void;
}
