<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\BootstrapAssistantInterface;
use Leonidas\Framework\Bootstrappers\AbstractBootstrapAssistant;

class SetWpConfig extends AbstractBootstrapAssistant implements BootstrapAssistantInterface
{
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
