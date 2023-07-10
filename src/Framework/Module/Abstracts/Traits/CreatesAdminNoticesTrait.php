<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;

trait CreatesAdminNoticesTrait
{
    protected function addAdminNotice(AdminNoticeInterface $notice): void
    {
        $this->adminNoticeRepository()->add($notice);
    }

    protected function adminNoticeRepository(): AdminNoticeRepositoryInterface
    {
        return $this->getService(AdminNoticeRepositoryInterface::class);
    }

    abstract protected function getService(string $service);
}
