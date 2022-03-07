<?php

namespace Leonidas\Enum\Extension;

use Leonidas\Enum\BackedEnum;

final class ExtensionType extends BackedEnum
{
    public const Plugin = 'plugin';
    public const Theme = 'theme';
    public const MuPlugin = 'mu-plugin';
    public const Mixin = 'mixin';
}
