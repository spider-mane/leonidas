<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Abstracts\ExtensionLoaderTrait;
use Leonidas\Framework\Exception\PluginInitiationException;
use Leonidas\Framework\Exception\ThemeInitiationException;
use Panamax\Contracts\ServiceContainerInterface;
use WebTheory\Config\Interfaces\ConfigInterface;

class ExtensionLoader implements ExtensionLoaderInterface
{
    use ExtensionLoaderTrait {
        __construct as public;
        bootstrap as public;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function getContainer(): ServiceContainerInterface
    {
        return $this->container;
    }

    public function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    public function error(): void
    {
        $backtrace = debug_backtrace();
        $caller = $backtrace[1];
        $method = $caller['class'] . $caller['type'] . $caller['function'];

        switch ($this->extension->getType()) {
            case 'theme':
                throw new ThemeInitiationException(
                    $this->extension->getName(),
                    $method
                );

            case 'plugin':
                throw new PluginInitiationException(
                    $this->extension->getName(),
                    $method
                );
        }
    }
}
