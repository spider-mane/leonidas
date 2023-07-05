<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Processing\Setting\SettingRegistrarInterface;
use Leonidas\Contracts\Option\OptionRepositoryInterface;
use Leonidas\Library\Admin\Processing\Setting\SettingCallbackProvider;
use Leonidas\Library\Admin\Processing\Setting\SettingNoticeInjector;
use Leonidas\Library\Admin\Processing\Setting\SettingRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class SettingRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): SettingRegistrarInterface
    {
        $callbackProvider = new SettingCallbackProvider(
            $container->get(OptionRepositoryInterface::class),
            new SettingNoticeInjector()
        );

        return new SettingRegistrar($callbackProvider);
    }
}
