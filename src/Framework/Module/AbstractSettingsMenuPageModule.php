<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\SettingsPageModuleTrait;

abstract class AbstractSettingsMenuPageModule extends AbstractMenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
