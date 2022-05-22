<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Traits\SettingsPageModuleTrait;

abstract class SettingsSubmenuPageModule extends SubmenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
