<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\SettingsFieldRegistrarInterface;
use Leonidas\Library\Admin\Callback\SettingsFieldCallbackProvider;
use Leonidas\Library\Admin\Registrar\SettingsFieldRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class SettingsFieldRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): SettingsFieldRegistrarInterface
    {
        return new SettingsFieldRegistrar(new SettingsFieldCallbackProvider());
    }
}
