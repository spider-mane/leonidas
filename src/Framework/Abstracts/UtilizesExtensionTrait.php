<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Extension\WpExtensionInterface;

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

    protected function prefix(string $value, string $separator = '_'): string
    {
        return $this->getExtension()->prefix($value, $separator);
    }

    protected function key(string $value = ''): string
    {
        return $this->prefix($value, '_');
    }

    protected function slug(string $value = ''): string
    {
        return $this->prefix($value, '-');
    }

    protected function scoped(string $value = ''): string
    {
        return $this->prefix($value, ':');
    }

    protected function scopedKey(string $value = ''): string
    {
        return $this->prefix($value, '__');
    }

    protected function scopedSlug(string $value = ''): string
    {
        return $this->prefix($value, '--');
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

    abstract protected function getExtension(): WpExtensionInterface;
}
