<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;

trait CreatesAdminNoticesTrait
{
    protected function addAdminNotice(AdminNoticeInterface $notice): void
    {
        $this->adminNoticeRepository()->add($notice);
    }

    abstract protected function adminNoticeRepository(): AdminNoticeRepositoryInterface;
}
