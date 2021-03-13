<?php

namespace Leonidas\Contracts\Extension\Plugin;

use Leonidas\Contracts\Extension\BaseModuleInterface;

interface PluginModuleInterface extends BaseModuleInterface
{
    public function __construct(PluginInterface $plugin);
}
