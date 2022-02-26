<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\SettingsPageModuleTrait;

abstract class AbstractSettingsSubmenuPageModule extends AbstractSubmenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
