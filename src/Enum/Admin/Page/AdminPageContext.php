<?php

namespace Leonidas\Enum\Admin\Page;

use Leonidas\Enum\BackedEnum;

final class AdminPageContext extends BackedEnum
{
    public const Menu = 'menu';
    public const Submenu = 'submenu';
    public const Interior = 'interior';
}
