<?php

namespace Leonidas\Framework\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Throwable;

trait UtilizesExtensionTrait
{
    protected function absPath(string $file): string
    {
        return $this->getExtension()->absPath($file);
    }

    protected function relPath(string $file): string
    {
        return $this->getExtension()->relPath($file);
    }

    protected function hasService(string $service): bool
    {
        return $this->getExtension()->has($service);
    }

    protected function getService(string $service)
    {
        return $this->getExtension()->get($service);
    }

    protected function hasConfig(string $key): bool
    {
        return $this->getExtension()->hasConfig($key);
    }

    protected function getConfig(string $key, $default = null)
    {
        return $this->getExtension()->config($key, $default);
    }

    protected function configCascade(array $cascade, $default = null)
    {
        foreach ($cascade as $key) {
            if ($this->hasConfig($key)) {
                return $this->getConfig($key);
            }
        }

        return $default;
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        if ($this->hasService($service = $this->serverRequestServiceId())) {
            return $this->getService($service);
        }

        throw $this->serverRequestNotFoundException();
    }

    protected function serverRequestNotFoundException(): Throwable
    {
        $interface = ServerRequestInterface::class;

        return new RuntimeException(
            "Instance of $interface could not be found. Make sure you provide an instance of $interface in your container."
        );
    }

    protected function serverRequestServiceId(): string
    {
        return ServerRequestInterface::class;
    }

    abstract protected function getExtension(): WpExtensionInterface;
}
