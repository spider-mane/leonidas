<?php

namespace Leonidas\Enum\Admin\Post;

use Leonidas\Enum\BackedEnum;

final class PostScreenContext extends BackedEnum
{
    public const High = 'normal';
    public const Side = 'side';
    public const Advanced = 'advanced';
}
