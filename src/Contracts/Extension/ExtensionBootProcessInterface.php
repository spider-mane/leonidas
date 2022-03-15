<?php

namespace Leonidas\Contracts\Extension;

use Panamax\Contracts\ServiceContainerInterface;

interface ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void;
}
