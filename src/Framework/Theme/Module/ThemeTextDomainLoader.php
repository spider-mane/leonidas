<?php

namespace Leonidas\Framework\Theme\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsAfterSetupThemeHook;

class ThemeTextDomainLoader extends Module
{
    use TargetsAfterSetupThemeHook;

    public function hook(): void
    {
        $this->targetAfterSetupThemeHook();
    }

    protected function doAfterSetupThemeAction(): void
    {
        load_theme_textdomain($this->textdomain(), $this->textdomainPath());
    }

    protected function textdomainPath()
    {
        return false;
    }

    protected function textdomain(): string
    {
        return $this->extension->getSlug();
    }
}
