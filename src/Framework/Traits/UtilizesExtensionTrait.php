<?php

namespace Leonidas\Framework\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
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
        if ($request = $this->serverRequestService()) {
            return $request;
        } elseif ($factory = $this->serverRequestFactoryService()) {
            $request = $factory->createServerRequest(
                $_SERVER['REQUEST_METHOD'],
                $_SERVER['REQUEST_URI'],
                $_SERVER
            );

            return $request
                ->withCookieParams($_COOKIE)
                ->withQueryParams($_GET)
                ->withParsedBody($_POST)
                ->withUploadedFiles($_FILES);
        }

        throw $this->serverRequestNotFoundException();
    }

    protected function serverRequestNotFoundException(): Throwable
    {
        $concrete = ServerRequestInterface::class;
        $factory = ServerRequestFactoryInterface::class;

        return new RuntimeException(
            "Instance of $concrete could not be found or created. Make sure you provide an instance of $concrete or $factory in your container."
        );
    }

    protected function serverRequestService(): ?ServerRequestInterface
    {
        $service = $this->serverRequestServiceId();

        return $this->hasService($service) ? $this->getService($service) : null;
    }

    protected function serverRequestFactoryService(): ?ServerRequestFactoryInterface
    {
        $service = $this->serverRequestFactoryServiceId();

        return $this->hasService($service) ? $this->getService($service) : null;
    }

    protected function serverRequestServiceId(): string
    {
        return ServerRequestInterface::class;
    }

    protected function serverRequestFactoryServiceId(): string
    {
        return ServerRequestFactoryInterface::class;
    }

    abstract protected function getExtension(): WpExtensionInterface;
}
