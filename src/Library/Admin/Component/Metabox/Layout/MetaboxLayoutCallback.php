<?php

namespace Leonidas\Library\Admin\Component\Metabox\Layout;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Component\ComponentCallback;

class MetaboxLayoutCallback extends ComponentCallback implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
