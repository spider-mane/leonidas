<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\SettingsPageModuleTrait;

abstract class AbstractSettingsMenuPageModule extends AbstractMenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
