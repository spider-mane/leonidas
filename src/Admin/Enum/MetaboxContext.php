<?php

namespace WebTheory\Leonidas\Admin\Enum;

use MyCLabs\Enum\Enum;

final class MetaboxContext extends Enum
{
    protected const HIGH = 'normal';
    protected const CORE = 'side';
    protected const DEFAULT = 'advanced';
}
