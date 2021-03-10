<?php

namespace WebTheory\Leonidas\Library\Admin\Metabox;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Library\Admin\AbstractLazyAdminComponent;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;

class LazyMetaboxLayout extends AbstractLazyAdminComponent implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
