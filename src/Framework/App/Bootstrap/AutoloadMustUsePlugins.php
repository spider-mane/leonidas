<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Roots\Bedrock\Autoloader;

class AutoloadMustUsePlugins implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        if (is_blog_installed()) {
            new Autoloader();
        }
    }
}
