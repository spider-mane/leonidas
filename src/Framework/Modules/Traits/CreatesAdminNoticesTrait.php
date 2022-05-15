<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Admin\Component\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticeRepositoryInterface;

trait CreatesAdminNoticesTrait
{
    protected function addAdminNotice(AdminNoticeInterface $notice): void
    {
        $this->adminNoticeRepository()->add($notice);
    }

    abstract protected function adminNoticeRepository(): AdminNoticeRepositoryInterface;
}
