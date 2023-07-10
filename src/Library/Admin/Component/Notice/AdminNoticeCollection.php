<?php

namespace Leonidas\Library\Admin\Component\Notice;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Library\Core\Abstracts\AbstractObjectCollection;

class AdminNoticeCollection extends AbstractObjectCollection implements AdminNoticeCollectionInterface
{
    protected const COLLECTION_IS_MAP = true;

    protected const ENTRY_IDENTIFIER = 'id';

    public function __construct(AdminNoticeInterface ...$notices)
    {
        $this->initKernel($notices);
    }

    public function get(string $notice): AdminNoticeInterface
    {
        return $this->kernel->fetch($notice);
    }

    public function add(AdminNoticeInterface $notice): bool
    {
        return $this->kernel->insert($notice);
    }

    public function batch(AdminNoticeInterface ...$notices)
    {
        $this->kernel->collect($notices);
    }

    public function has(string $notice): bool
    {
        return $this->kernel->contains($notice);
    }

    public function remove(string $notice): bool
    {
        return $this->kernel->remove($notice);
    }
}
