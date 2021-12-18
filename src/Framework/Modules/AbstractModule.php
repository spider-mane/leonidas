<?php

namespace Leonidas\Framework\Modules;

use Dotenv\Util\Str;
use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var WpExtensionInterface
     */
    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    protected function absPath(string $file): string
    {
        return $this->extension->absPath($file);
    }

    protected function relPath(string $file): string
    {
        return $this->extension->relPath($file);
    }

    protected function hasService(string $service): bool
    {
        return $this->extension->has($service);
    }

    protected function getService(string $service)
    {
        return $this->extension->get($service);
    }

    protected function hasConfig(string $key): bool
    {
        return $this->extension->hasConfig($key);
    }

    protected function getConfig(string $key)
    {
        return $this->extension->config($key);
    }

    protected function configCascade(array $cascade)
    {
        foreach ($cascade as $key) {
            if ($this->hasConfig($key)) {
                return $this->getConfig($key);
            }
        }
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        if ($this->hasService(ServerRequestInterface::class)) {
            return $this->getService(ServerRequestInterface::class);
        }

        return ServerRequest::fromGlobals();
    }
}
