<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Framework\Module\Abstracts\AdminNoticeLoaderModule;

class AdminNoticeLoader extends AdminNoticeLoaderModule
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
