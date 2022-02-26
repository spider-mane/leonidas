<?php

namespace Leonidas\Framework\Modules\Traits;

trait SettingsPageModuleTrait
{
    use HandlesSettingsApiTrait;

    public function hook(): void
    {
        $this->targetAdminInitHook();
        parent::hook();
    }

    protected function initiationContexts(): array
    {
        return [
            'admin_init' => $this->settingsApiAdminInitProperties(),
        ] + parent::initiationContexts();
    }
}
