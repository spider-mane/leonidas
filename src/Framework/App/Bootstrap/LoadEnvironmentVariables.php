<?php

namespace Leonidas\Framework\App\Bootstrap;

use Dotenv\Dotenv;
use Env\Env;
use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;

use function WebTheory\Config\env;

class LoadEnvironmentVariables implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        Env::$options |= Env::USE_ENV_ARRAY;

        $env = Dotenv::createImmutable($extension->absPath());

        $env->load();

        $this->validateRequirements($env);
    }

    protected function validateRequirements(Dotenv $env): void
    {
        $env->required(['WP_HOME', 'WP_SITEURL']);

        if (!env('DATABASE_URL')) {
            $env->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
        }
    }
}
