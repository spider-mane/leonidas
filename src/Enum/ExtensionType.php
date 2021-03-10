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
    private const PLUGIN = 'plugin';
    private const THEME = 'theme';
    private const MU_PLUGIN = 'mu-plugin';
    private const MIXIN = 'mixin';
}
