<?php

namespace Leonidas\Library\Admin\Metabox;

use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Library\Admin\AbstractLazyLoadedAdminComponent;
use Leonidas\Traits\CanBeRestrictedTrait;

class LazyLoadedMetaboxLayout extends AbstractLazyLoadedAdminComponent implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
