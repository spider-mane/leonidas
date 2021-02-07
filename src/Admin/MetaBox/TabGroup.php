<?php

namespace WebTheory\Leonidas\Admin\Metabox;

use WebTheory\Leonidas\Admin\Metabox\Contracts\MetaboxContentInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class TabGroup implements MetaboxContentInterface
{
    use CanBeRestrictedTrait;
}
