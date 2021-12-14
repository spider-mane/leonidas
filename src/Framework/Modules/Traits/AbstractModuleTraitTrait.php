<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;

trait AbstractModuleTraitTrait
{
    abstract protected function getServerRequest(): ServerRequestInterface;

    abstract protected function getExtension(): WpExtensionInterface;
}
