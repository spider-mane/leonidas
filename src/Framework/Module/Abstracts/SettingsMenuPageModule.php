<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Traits\HandlesSettingsApiTrait;
use Leonidas\Hooks\TargetsAdminInitHook;

abstract class SettingsMenuPageModule extends MenuPageModule implements ModuleInterface
{
    use HandlesSettingsApiTrait;
    use TargetsAdminInitHook;

    public function hook(): void
    {
        $this->targetAdminInitHook();
        parent::hook();
    }

    protected function doAdminInitAction(): void
    {
        $this->registerSettingsApi();
    }
}
