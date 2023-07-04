<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Callback\AdminPageCallbackProviderInterface;
use Leonidas\Framework\Provider\AdminPageCallbackProviderProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class AdminPageCallbackProviderServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'admin_page_callback_provider';
    }

    protected function types(): array
    {
        return [AdminPageCallbackProviderInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AdminPageCallbackProviderProvider();
    }
}
