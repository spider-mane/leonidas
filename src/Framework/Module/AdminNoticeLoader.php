<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;

class AdminNoticeLoader extends AbstractAdminNoticeLoaderModule implements ModuleInterface
{
    protected function repository(): AdminNoticeRepositoryInterface
    {
        return $this->getService($this->repositoryService());
    }

    protected function repositoryService(): string
    {
        return 'admin_notice_repository';
    }
}
