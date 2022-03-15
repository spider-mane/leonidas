<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;
use WebTheory\Facade\FacadeBaseTrait;

class BindContainerToFacades implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        /** @var FacadeBaseTrait $base */
        $base = $extension->config('app.facade');

        $base::_setFacadeContainer($container);
    }
}
