<?php

namespace Leonidas\Framework\App\Bootstrap;

use Env\Env;
use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;

class DefineConfigConstants implements ExtensionBootProcessInterface
{
    public const DEFAULT_KEYS = ['wp'];

    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $env = strtolower(Env::get('APP_ENV'));
        $keys = $extension->config($this->optionKey(), $this->defaultKeys());

        foreach ($keys as $key) {
            $config = $extension->config($key, []);
            $definitions = array_change_key_case(
                array_merge(
                    $config['@global'] ?? [],
                    $config['@' . $env] ?? []
                ) ?: $config,
                CASE_UPPER
            );

            foreach ($definitions as $name => $value) {
                define($name, $value);
            }
        }
    }

    protected function optionKey(): string
    {
        return 'boot.options.constants';
    }

    protected function defaultKeys(): iterable
    {
        return static::DEFAULT_KEYS;
    }
}
