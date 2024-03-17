<?php

namespace Leonidas\Framework;

use Env\Env;
use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;
use WebTheory\Config\StackedConfig;

class DevLoader extends ExtensionLoader implements ExtensionLoaderInterface
{
    public function __construct(string $path)
    {
        parent::__construct('local', $path, Env::get('WP_HOME'));
    }

    protected function getContainerScript(): string
    {
        return 'boot/development/container.php';
    }

    protected function defineConfig(): ConfigInterface
    {
        $mainConfig = parent::defineConfig();
        $mainConfig->set('app.bootstrap', []);

        return new StackedConfig(
            new Config($this->path . '/config/development'),
            $mainConfig
        );
    }

    protected function getBootScriptDir(): string
    {
        return 'boot/development';
    }
}
