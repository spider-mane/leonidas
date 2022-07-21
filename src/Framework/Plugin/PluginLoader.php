<?php

namespace Leonidas\Framework\Plugin;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Framework\ExtensionLoader;

class PluginLoader extends ExtensionLoader implements ExtensionLoaderInterface
{
    public function __construct(string $base)
    {
        parent::__construct('plugin', Plugin::path($base), Plugin::url($base));
    }
}
