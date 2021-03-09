<?php

namespace WebTheory\Leonidas\Admin\Page;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractLazyAdminComponent;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class LazyAdminPageLayout extends AbstractLazyAdminComponent implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
