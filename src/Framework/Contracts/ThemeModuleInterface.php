<?php

namespace WebTheory\Leonidas\Framework\Contracts;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;

interface ThemeModuleInterface extends ModuleInterface
{
    /**
     *
     */
    public function __construct(ThemeInterface $theme);
}
