<?php

namespace Leonidas\Framework\App\Bootstrap;

use Dotenv\Dotenv;
use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;

class LoadEnvironmentVariables implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $env = Dotenv::createUnsafeImmutable($extension->absPath());

        $env->required(['WP_HOME', 'WP_SITEURL']);

        if (!env('DATABASE_URL')) {
            $env->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
        }

        $env->load();
    }
}
