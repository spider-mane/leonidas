<?php

namespace Leonidas\Contracts\Extension;

interface ModuleInterface extends BaseModuleInterface
{
    public function __construct(WpExtensionInterface $extension);
}
