<?php

namespace WebTheory\Leonidas\Admin\Metabox;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractLazyAdminComponent;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class LazyMetaboxLayout extends AbstractLazyAdminComponent implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
