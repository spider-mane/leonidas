<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Component\AdminNoticeRepositoryInterface;
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
