<?php

namespace Leonidas\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static ExtensionType PLUGIN()
 * @method static ExtensionType THEME()
 * @method static ExtensionType MU_PLUGIN()
 * @method static ExtensionType MIXIN()
 */
final class ExtensionType extends Enum
{
    protected const PLUGIN = 'plugin';
    protected const THEME = 'theme';
    protected const MU_PLUGIN = 'mu-plugin';
    protected const MIXIN = 'mixin';
}
