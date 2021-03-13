<?php

namespace Leonidas\Enum\Admin;

use MyCLabs\Enum\Enum;

final class PostScreenContext extends Enum
{
    protected const HIGH = 'normal';
    protected const CORE = 'side';
    protected const DEFAULT = 'advanced';
}
