<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;

class DefineConfigConstants implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        foreach ($this->configKeys() as $key) {
            $contexts = $extension->config($key, []);
            $config = array_change_key_case(
                array_merge(
                    $contexts['default'] ?? [],
                    $contexts[env('APP_ENV')] ?? []
                ) ?: $contexts,
                CASE_UPPER
            );

            foreach ($config as $name => $value) {
                define($name, $value);
            }
        }
    }

    protected function configKeys(): iterable
    {
        return ['wp.config'];
    }
}
