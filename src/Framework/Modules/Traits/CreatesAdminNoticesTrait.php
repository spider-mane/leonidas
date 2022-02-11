<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeRepositoryInterface;

trait CreatesAdminNoticesTrait
{
    protected function addAdminNotice(AdminNoticeInterface $notice): void
    {
        $this->adminNoticeRepository()->add($notice);
    }

    abstract protected function adminNoticeRepository(): AdminNoticeRepositoryInterface;
}
