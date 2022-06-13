<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\AdminNoticeRepositoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Library\Admin\Repository\AdminNoticeRepository;
use Panamax\Contracts\ServiceFactoryInterface;

class AdminNoticeRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'admin_notices';
    }

    protected function types(): array
    {
        return [AdminNoticeRepository::class];
    }

    protected function aliases(): array
    {
        return ['adminNotices'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AdminNoticeRepositoryProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('admin.notices');
    }
}
