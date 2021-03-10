<?php

namespace WebTheory\Leonidas\Library\Admin\Page;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Library\Admin\AbstractLazyAdminComponent;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;

class LazyAdminPageLayout extends AbstractLazyAdminComponent implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
