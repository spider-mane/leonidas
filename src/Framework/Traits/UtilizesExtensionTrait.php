<?php

namespace Leonidas\Framework\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        /** @var ServerRequestFactoryInterface $factory */
        $factory = $this->getService(ServerRequestFactoryInterface::class);

        $request = $factory->createServerRequest(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_SERVER
        );

        return $request
            ->withCookieParams($_COOKIE)
            ->withQueryParams($_GET)
            ->withParsedBody($_POST)
            ->withUploadedFiles(self::normalizeFiles($_FILES));
    }

    abstract protected function getExtension(): WpExtensionInterface;
}
