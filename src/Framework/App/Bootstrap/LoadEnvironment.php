<?php

namespace Leonidas\Framework\App\Bootstrap;

use Dotenv\Dotenv;
use Leonidas\Contracts\Extension\BootstrapAssistantInterface;
use Leonidas\Framework\Bootstrappers\AbstractBootstrapAssistant;

class LoadEnvironment extends AbstractBootstrapAssistant implements BootstrapAssistantInterface
{
    public function boot(): void
    {
        $env = Dotenv::createUnsafeImmutable($this->extension->absPath());
        $env->load();

        $env->required(['WP_HOME', 'WP_SITEURL']);

        if (!env('DATABASE_URL')) {
            $env->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
        }
    }
}
