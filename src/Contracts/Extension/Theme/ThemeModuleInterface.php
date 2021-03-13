<?php

namespace Leonidas\Contracts\Extension\Theme;

use Leonidas\Contracts\Extension\BaseModuleInterface;

interface ThemeModuleInterface extends BaseModuleInterface
{
    public function __construct(ThemeInterface $theme);
}
