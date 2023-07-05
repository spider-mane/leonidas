<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Leonidas\Library\Admin\Callback\SettingsSectionCallbackProvider;
use Leonidas\Library\Admin\Registrar\SettingsSectionRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class SettingsSectionRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): SettingsSectionRegistrarInterface
    {
        return new SettingsSectionRegistrar(new SettingsSectionCallbackProvider());
    }
}
