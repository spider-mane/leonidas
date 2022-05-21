<?php

namespace Leonidas\Framework\Theme\Module\Abstracts;

use Closure;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\AbstractModule;

abstract class ThemeSetupModule extends AbstractModule implements ModuleInterface
{
    public function hook(): void
    {
        $this->targetAfterThemeSetupHook();
    }

    protected function targetAfterThemeSetupHook()
    {
        add_action(
            'after_theme_setup',
            Closure::fromCallable([$this, 'doAfterThemeSetUpAction'])
        );
    }

    protected function doAfterThemeSetUpAction(): void
    {
        $this->loadThemeTextDomain();
        $this->features();
    }

    protected function loadThemeTextDomain()
    {
        load_theme_textdomain($this->textdomain(), $this->textdomainPath());
    }

    protected function textdomainPath()
    {
        return false;
    }

    abstract protected function textdomain(): string;

    abstract protected function features(): void;
}
