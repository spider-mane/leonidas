<?php

namespace Leonidas\Framework\App\Bootstrap;

use Dotenv\Dotenv;
use Leonidas\Contracts\Extension\BootstrapAssistantInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;

class LoadEnvironment implements BootstrapAssistantInterface
{
    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

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
