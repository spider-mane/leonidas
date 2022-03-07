<?php

namespace Leonidas\Enum\Admin\Post;

use Leonidas\Enum\BackedEnum;

final class PostScreenPriority extends BackedEnum
{
    public const High = 'high';
    public const Core = 'core';
    public const Default = 'default';
    public const Low = 'low';
}
