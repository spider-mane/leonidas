<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;

trait AbstractModuleTraitTrait
{
    protected WpExtensionInterface $extension;

    abstract protected function getServerRequest(): ServerRequestInterface;

    abstract protected function getExtension(): WpExtensionInterface;
}
