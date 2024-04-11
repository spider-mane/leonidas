<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;
use WebTheory\Facade\Interfaces\FacadeInterface;

class BindContainerToFacades implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        /** @var FacadeInterface */
        $base = $extension->config('boot.options.facade');

        $base::_setFacadeContainer($container);
    }
}
