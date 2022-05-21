<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Traits\SettingsPageModuleTrait;

abstract class AbstractSettingsMenuPageModule extends AbstractMenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
