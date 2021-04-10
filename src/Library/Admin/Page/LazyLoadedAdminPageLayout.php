<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Library\Admin\AbstractLazyLoadedAdminComponent;
use Leonidas\Traits\CanBeRestrictedTrait;

class LazyLoadedAdminPageLayout extends AbstractLazyLoadedAdminComponent implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
