<?php

namespace WebTheory\Leonidas\Admin\Page;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractAdminComponentCallback;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class AdminPageLayoutCallback extends AbstractAdminComponentCallback implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
