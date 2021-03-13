<?php

namespace Leonidas\Enum\Admin;

use MyCLabs\Enum\Enum;

final class PostScreenPriority extends Enum
{
    protected const HIGH = 'high';
    protected const CORE = 'core';
    protected const DEFAULT = 'default';
    protected const LOW = 'low';
}
