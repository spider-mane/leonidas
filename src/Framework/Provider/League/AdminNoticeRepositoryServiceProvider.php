<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\AdminNoticeRepositoryProvider;
use Leonidas\Library\Admin\Repository\AdminNoticeRepository;
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
