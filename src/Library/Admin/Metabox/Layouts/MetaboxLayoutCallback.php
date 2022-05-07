<?php

namespace Leonidas\Library\Admin\Metabox\Layouts;

use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\ComponentCallback;

class MetaboxLayoutCallback extends ComponentCallback implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
