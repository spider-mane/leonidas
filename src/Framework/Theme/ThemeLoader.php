<?php

namespace Leonidas\Framework\Theme;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Framework\ExtensionLoader;

class ThemeLoader extends ExtensionLoader implements ExtensionLoaderInterface
{
    public function __construct()
    {
        parent::__construct('theme', Theme::path(), Theme::url());
    }
}
