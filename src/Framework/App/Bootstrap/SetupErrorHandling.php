<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;
use WebTheory\Exterminate\Exterminator;

class SetupErrorHandling implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        Exterminator::debug($extension->config('debug'));
    }
}
