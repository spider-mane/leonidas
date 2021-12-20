<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\BootstrapAssistantInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;

class SetWpConfig implements BootstrapAssistantInterface
{
    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    public function boot(): void
    {
        $contexts = $this->extension->config('wp.config', []);
        $config = array_change_key_case(
            array_merge(
                $contexts['default'] ?? [],
                $contexts[env('APP_ENV')] ?? []
            ),
            CASE_UPPER
        );

        foreach ($config as $name => $value) {
            define($name, $value);
        }
    }
}
