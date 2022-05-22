<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;

trait AbstractModuleTraitTrait
{
    protected WpExtensionInterface $extension;

    abstract protected function getServerRequest(): ServerRequestInterface;

    abstract protected function getExtension(): WpExtensionInterface;

    abstract protected function getService(string $service);

    abstract protected function getConfig(string $key, $default = null);
}
