<?php

namespace WebTheory\Leonidas\Contracts\Extension;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Contracts\Extension\ThemeInterface;

interface ThemeModuleInterface extends ModuleInterface
{
    /**
     *
     */
    public function __construct(ThemeInterface $theme);
}
