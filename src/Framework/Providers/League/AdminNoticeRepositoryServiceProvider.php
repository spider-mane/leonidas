<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\AdminNoticeRepositoryProvider;
use Leonidas\Library\Admin\Notice\AdminNoticeRepository;
use Panamax\Contracts\ServiceFactoryInterface;

class AdminNoticeRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return AdminNoticeRepository::class;
    }

    protected function serviceTags(): array
    {
        return ['admin_notices', 'adminNotices'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new AdminNoticeRepositoryProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('admin.notices');
    }
}
