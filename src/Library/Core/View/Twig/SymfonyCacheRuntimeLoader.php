<?php

namespace Leonidas\Library\Core\View\Twig;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Twig\Extra\Cache\CacheRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class SymfonyCacheRuntimeLoader implements RuntimeLoaderInterface
{
    public function load(string $class): ?CacheRuntime
    {
        if (CacheRuntime::class !== $class) {
            return null;
        }

        return new CacheRuntime(new TagAwareAdapter(new FilesystemAdapter()));
    }
}
