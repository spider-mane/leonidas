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
            $config = $extension->config($key, []);
            $definitions = array_change_key_case(
                array_merge(
                    $config['@global'] ?? [],
                    $config['@' . strtolower(env('APP_ENV'))] ?? []
                ) ?: $config,
                CASE_UPPER
            );

            foreach ($definitions as $name => $value) {
                define($name, $value);
            }
        }
    }

    protected function configKeys(): iterable
    {
        return ['wp.config'];
    }
}
