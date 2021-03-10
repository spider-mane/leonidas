<?php

namespace Leonidas\Library\Admin\Metabox;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Library\Admin\AbstractLazyAdminComponent;
use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Traits\CanBeRestrictedTrait;

class LazyMetaboxLayout extends AbstractLazyAdminComponent implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
