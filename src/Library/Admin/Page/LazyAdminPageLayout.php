<?php

namespace Leonidas\Library\Admin\Page;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Library\Admin\AbstractLazyAdminComponent;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Traits\CanBeRestrictedTrait;

class LazyAdminPageLayout extends AbstractLazyAdminComponent implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
