<?php

namespace Leonidas\Library\Admin\Metabox\Layouts;

use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Library\Admin\ComponentCallback;
use Leonidas\Traits\CanBeRestrictedTrait;

class MetaboxLayoutCallback extends ComponentCallback implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
